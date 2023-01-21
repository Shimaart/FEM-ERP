<?php

namespace App\Http\Livewire\Productions;

use App\Models\Item;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Production;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class ProductionForm extends Component
{
    use AuthorizesRequests;

    public Production $production;
    public $values;
    public $materialValues;
    public $productionItems;
    public $materials;

    protected $listeners = ['consumedMaterialsUpdated' => '$refresh'];

    public function mount(Production $production)
    {
        // TODO check permissions

//        $this->authorize('receive', $production);
//        $this->authorize('process', $production);

//        v blade
//        @can('receive', $production);
//        @can('process', $production);

        $this->values = $this->getValues();
        $this->materialValues = $this->getMaterialValues();
        $this->production = $production;

        $this->production->load([
            'productionItems', 'productionItems.item','productionItems.materials',
            'comments' => function ($query) {
                return $query->latest();
            }
        ]);
    }

    public function rules ()
    {
        return [
            'production.date' => ['nullable', 'date:Y-m-d'],
            'productionItems' => ['nullable', 'array'],
            'materials' => ['nullable', 'array'],
        ];
    }

    public function submit(): void
    {
        $this->materialValues = $this->getMaterialValues();
        $this->validate();

        if ($this->production->status === Production::STATUS_CREATED && !$this->productionItems) {
            $this->addError('productionItems', 'Укажите произведнное к-во');
        }

//        if ($this->production->status === Production::STATUS_CREATED && !$this->materials) {
//            $this->addError('productionItems', 'Укажите затраченые материалы');
//        }

        if ($this->production->status === Production::STATUS_RECEIVED) {
            $this->addError('productionItems', 'Укажите принятое к-во');
        }

//        dd($this->getErrorBag());
        if (!$this->getErrorBag()->messages()) {
            if ($this->production->status === Production::STATUS_PROCESSED) {
                foreach ($this->productionItems as $key => $productionItem) {
                    $receivedItem = $this->production->productionItems()->where('id',$key)->first();
                    if(isset($productionItem['received_quantity'])) {
                        $receivedItem->update([
                            'received_quantity' => $productionItem['received_quantity'],
                        ]);
                    }
                    $item = $receivedItem->item;
                    $receivedItem->item->update([
                        'quantity' =>  $item->quantity + $receivedItem->received_quantity
                    ]);
                }

                $this->production->update([
                    'status' => Production::STATUS_RECEIVED
                ]);

                $this->production->comments()->create([
                    'author_id' => Auth::user()->id,
                    'comment' => 'Продукция принята',
                    'status' => Production::STATUS_RECEIVED
                ]);
            }

//            dd($this->production->status);
            if ($this->production->status === Production::STATUS_CREATED  && $this->productionItems) {
                foreach ($this->productionItems as $key => $productionItem) {
                    $item = $this->production->productionItems()->where('id',$key)->first();
                    if(isset($productionItem['processed_quantity'])) {
                        $item->update([
                            'processed_quantity' => $productionItem['processed_quantity'],
                        ]);
                    } else {
//                        dd(333333);

                        $this->addError('productionItems', 'Укажите произведнное к-во');
                    }
                    if(isset($productionItem['defects_count'])) {
                        $item->update([
                            'defects_count' => $productionItem['defects_count'],
                        ]);
                    } else {
//                        dd(2222222);
                        $this->addError('productionItems', 'Укажите к-во брака');
                    }
                }


                foreach ($this->production->productionItems as $oneProductionItem) {
                    if (!$oneProductionItem->materials()->count()) {
                        $this->addError('productionItems', 'Укажите затраченые материалы');
                    }
                }
//            foreach ($this->materials as $materialId => $material) {
//                $item->materials()->create([
//                    'material_id' => $materialId,
//                    'value' => $material['quantity']
//                ]);
//
//                $materialItem = Item::query()->where('id',$materialId)->first();
//                $materialItem->update([
//                    'quantity' =>  $materialItem->quantity - $material['quantity']
//                ]);
//            }

                if (!$this->getErrorBag()->messages()) {
                    $this->production->update([
                        'status' => Production::STATUS_PROCESSED
                    ]);

                    $this->production->comments()->create([
                        'author_id' => Auth::user()->id,
                        'comment' => 'Продукция произведена',
                        'status' => Production::STATUS_PROCESSED
                    ]);
                }
            }
        }

        if (!$this->getErrorBag()->messages()) {
            $this->emit('saved');
            $this->redirect('/productions/'.$this->production->id.'/edit');
        }
    }

    public function getValues()
    {
        $results = [];
        $values = [];

//        $items = Item::query()
//            ->whereHas();

        $products = OrderItem::query()
            ->whereHas('order', function (Builder $query){
                $query->whereIn('orders.status', [Order::STATUS_CREATED, Order::STATUS_ACTIVE]);
            })
            ->whereHas('item', function (Builder $query){
                $query->whereRaw('items.quantity < order_items.quantity');
            })
            ->get();

        foreach ($products as $product) {
            $startValue = isset($results[(int)$product->item_id]) ? $results[(int)$product->item_id] : 0;
            $results[(int)$product->item_id] = $startValue + $product->quantity;
        }

        foreach ($results as $key => $result) {
            $item = Item::query()->where('id', $key)->first();
            if ($item->quantity < $result) {
                $values[] = [
                    'item' => $item,
                    'need_quantity' => $result - $item->quantity,
                    'orders' => $products->where('item_id',$item->id)->pluck('order_id'),
                ];
            }
        }

        return $values;
    }

    public function getMaterialValues()
    {
        $materials = Item::query()
            ->whereHas('itemCategory', function (Builder $query) {
                $query->where('name', '=', 'Сырье');
            })
            ->limit(7)
            ->get();
        return $materials;
    }
}
