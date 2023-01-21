<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

/**
 * App\Models\Item
 *
 * @property int $id
 * @property int|null $category_id
 * @property int|null $unit_id
 * @property int|null $item_type_id
 * @property string $name
 * @property string $price
 * @property string $cost_price
 * @property string $purchase_price
 * @property string $return_price
 * @property bool $is_preferential
 * @property string|null $weight
 * @property float $quantity
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\ItemAttribute[] $attributes
 * @property-read int|null $attributes_count
 * @property-read float $reserved_quantity
 * @property-read float $unused_quantity
 * @property-read float $shipment_used_quantity
 * @property-read float $shipment_available_quantity
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\AttributeGroup[] $groups
 * @property-read int|null $groups_count
 * @property-read \App\Models\ItemCategory|null $itemCategory
 * @property-read \App\Models\ItemType|null $itemType
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\OrderItem[] $orderItems
 * @property-read int|null $order_items_count
 * @property-read \App\Models\Unit|null $unit
 * @method static Builder|Item byCategorySlug(string $slug)
 * @method static Builder|Item newModelQuery()
 * @method static Builder|Item newQuery()
 * @method static Builder|Item query()
 * @method static Builder|Item whereCategoryId($value)
 * @method static Builder|Item whereCreatedAt($value)
 * @method static Builder|Item whereId($value)
 * @method static Builder|Item whereIsPreferential($value)
 * @method static Builder|Item whereItemTypeId($value)
 * @method static Builder|Item whereName($value)
 * @method static Builder|Item wherePrice($value)
 * @method static Builder|Item whereQuantity($value)
 * @method static Builder|Item whereUnitId($value)
 * @method static Builder|Item whereUpdatedAt($value)
 * @method static Builder|Item whereWeight($value)
 * @mixin \Eloquent
 */
class Item extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    protected $casts = [
        'quantity' => 'float',
        'is_preferential' => 'boolean'
    ];

    protected $attributes = [
        'is_preferential' => false
    ];

    public function getReservedQuantityAttribute(): float
    {
        return $this->orderItems()
            ->whereHas('order', function (Builder $query) {
                $query->whereIn('status', [
                    Order::STATUS_DRAFTED,
                    Order::STATUS_CREATED,
                    Order::STATUS_ACTIVE,
                    Order::STATUS_CANCELED,
                    Order::STATUS_READY
                ]);
            })
            ->sum('quantity');
    }

    public function getUnusedQuantityAttribute(): float
    {
        return (float)$this->quantity - (float)$this->reserved_quantity;
    }

    public function getShipmentUsedQuantityAttribute(): float
    {
        return ShipmentItem::query()
            ->whereHas('shipment', function (Builder $query) {
                $query->whereIn('status', [
                    Order::STATUS_CREATED
                ]);
            })
            ->whereHas('orderItem', function (Builder $query) {
                $query->where('item_id', $this->id);
            })
            ->sum('shipment_items.quantity');
    }

    public function getShipmentAvailableQuantityAttribute(): float
    {
        return (float)$this->quantity - (float)$this->shipment_used_quantity;
    }

    public function scopeByCategorySlug(Builder $query, string $slug): Builder
    {
        return $query->whereHas('itemCategory', function (Builder $query) use ($slug) {
            $query->where('slug',$slug);
        });
    }

    /*
    |--------------------------------------------------------------------------
    | Relationships
    |--------------------------------------------------------------------------
    */
    public function unit(): BelongsTo
    {
        return $this->belongsTo(Unit::class);
    }

    public function itemType(): BelongsTo
    {
        return $this->belongsTo(ItemType::class);
    }

    public function itemCategory(): BelongsTo
    {
        return $this->belongsTo(ItemCategory::class, 'category_id');
    }

    public function groups(): BelongsToMany
    {
        return $this->belongsToMany(AttributeGroup::class, 'item_attributes', 'item_id', 'group_id');
    }

    public function attributes(): HasMany
    {
        return $this->hasMany(ItemAttribute::class);
    }

//    public function optionalAttribute(): HasOne
//    {
//        return $this->hasOne(ItemAttribute::class)->where('is_main');
//    }

    public function orderItems(): HasMany
    {
        return $this->hasMany(OrderItem::class);
    }
}
