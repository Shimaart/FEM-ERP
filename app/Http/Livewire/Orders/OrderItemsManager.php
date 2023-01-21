<?php

namespace App\Http\Livewire\Orders;

use App\Models\Item;
use App\Models\ItemCategory;
use App\Models\ItemType;
use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Validation\Rule;
use Livewire\Component;

/**
 * @property-read  ItemType|null $itemType
 * @property-read  Collection|ItemType[] $itemTypes
 * @property-read  Collection|Item[] $items
 * @property-read  bool $shouldUseAttributes
 */
class OrderItemsManager extends Component
{
    public Order $order;
    public ?ItemCategory $category = null;

    public bool $managingOrderItem = false;
    public ?OrderItem $managedOrderItem = null;

    public $itemTypeId = null;
    public array $attributes = [];

    protected $listeners = [
        // emits update action from table
        'manageOrderItem' => 'manageOrderItem',
        'orderSaved' => '$refresh'
    ];

    public function rules(): array
    {
        $rules = [
            'managedOrderItem.order_id' => ['required', 'exists:orders,id'],
            'managedOrderItem.item_id' => ['required', 'exists:items,id'],
            'managedOrderItem.quantity' => ['required', 'numeric', 'min:0'],
            'managedOrderItem.price' => ['required', 'numeric', 'min:0'],

            'managedOrderItem.profit_percent' => ['nullable', 'numeric', 'min:0'],
            'managedOrderItem.warehouse_skipped' => ['nullable', 'boolean'],

            'managedOrderItem.discount' => ['required', 'numeric'],
            'itemTypeId' => ['required', 'exists:item_types,id'],
            'attributes' => ['array'],
            'attributes.*' => ['required', 'exists:attributes,id'],
        ];

        if ($this->managedOrderItem && $this->managedOrderItem->warehouse_skipped) {
            $rules['managedOrderItem.purchase_price'] = ['nullable', 'numeric', 'min:0'];
        }

        return $rules;


        if ($this->managedOrderItem && $this->managedOrderItem->item
            && $this->managedOrderItem->item->itemCategory
            && $this->managedOrderItem->item->itemCategory->slug === ItemCategory::SLUG_SERVICE
        ) {
            $rules['managedOrderItem.profit_percent'] =  ['nullable', 'numeric', 'min:0'];
        }

        if ($this->managedOrderItem && $this->managedOrderItem->item
            && $this->managedOrderItem->item->itemCategory
            && $this->managedOrderItem->item->itemCategory->slug === ItemCategory::SLUG_DEALER
        ) {
            $rules['managedOrderItem.warehouse_skipped'] =  ['nullable', 'boolean'];
            $rules['managedOrderItem.purchase_price'] =  ['nullable', 'numeric', 'min:0'];
        }

        return $rules;
    }

    public function getValidationAttributes(): array
    {
        return [
            'managedOrderItem.item_id' => __('Продукция'),
            'managedOrderItem.quantity' => __('Количество'),
            'managedOrderItem.price' => __('Цена за единицу'),
            'managedOrderItem.discount' => __('Скидка'),
            'managedOrderItem.profit_percent' => __('Процент зароботка'),

            'itemTypeId' => __('Продукция')
        ];
    }

    public function manageOrderItem(OrderItem $orderItem): void
    {
        $this->clearValidation();

        if (! $orderItem->order) {
            $orderItem->order()->associate($this->order);
        }

        $this->itemTypeId = $orderItem->item && $orderItem->item->itemType ? $orderItem->item->item_type_id : null;
        $this->attributes = $orderItem->item && $orderItem->item->attributes ?
            $orderItem->item->attributes->pluck('attribute_id', 'group_id')->toArray() : [];

        $this->managedOrderItem = $orderItem;
        $this->managingOrderItem = true;
    }

    public function saveOrderItem(): void
    {
        if (! $this->managedOrderItem) {
            return;
        }

        $this->validate();

        $this->order->orderItems()->save($this->managedOrderItem);

        $this->emit('orderItemSaved');

        $this->managingOrderItem = false;
        $this->managedOrderItem = null;
    }

    public function updatedManagedOrderItemItemId($itemId): void
    {
        if ($this->managedOrderItem && $item = Item::query()->find($itemId)) {
            $this->setItem($item);
        }
    }

    public function updatedAttributes($attributeId, $groupId): void
    {
        $this->clearValidation('managedOrderItem.item_id');

        if ($this->itemType && count($this->itemType->itemTypeGroups) <= count($this->attributes)) {
            $query = Item::query();
            $query->where(['item_type_id' => $this->itemTypeId]);
            foreach ($this->attributes as $groupId => $attributeId) {
                $query->whereHas('attributes', function (Builder $query) use ($groupId, $attributeId) {
                    $query->where('attribute_id', '=', $attributeId)
                        ->where('group_id', '=', $groupId);
                });
            }

            if ($item = $query->first()) {
                $this->setItem($item);
            } else {
                $this->unsetItem();
                $this->addError('managedOrderItem.item_id', __('По указанным критериям не найдено продукции.'));
            }
        }
    }

    private function setItem(Item $item): void
    {
        $this->managedOrderItem->item_id = $item->id;
        $this->managedOrderItem->item()->associate($item);
        //@TODO normal validation
        if((int)$this->itemTypeId === 4) $this->managedOrderItem->profit_percent = 10;

        // set default item price
        $this->managedOrderItem->price = $item->price;
    }

    private function unsetItem(): void
    {
        $this->managedOrderItem->item_id = null;
        $this->managedOrderItem->item()->dissociate();

        $this->managedOrderItem->price = null;
    }

    public function getItemTypeProperty(): ?ItemType
    {
        return $this->itemTypes->find($this->itemTypeId);
    }

    public function getShouldUseAttributesProperty(): bool
    {
        return $this->itemType && count($this->itemType->itemTypeGroups) > 0;
    }

    public function getItemTypesProperty(): Collection
    {
        return ItemType::all();
    }

    public function getItemsProperty(): Collection
    {
        $query = $this->category ?
            Item::query()->where('category_id', $this->category->id) :
            Item::query();

        $query->whereHas('itemType', fn(Builder $query) => $query->where('id', '=', $this->itemTypeId));

        return $query->get();
    }
}
