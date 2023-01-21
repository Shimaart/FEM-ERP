<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * App\Models\ShipmentItem
 *
 * @property int $id
 * @property int $shipment_id
 * @property int $item_id
 * @property string $quantity
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read float|null $total_weight
 * @property-read \App\Models\OrderItem $orderItem
 * @property-read \App\Models\Shipment $shipment
 * @method static \Illuminate\Database\Eloquent\Builder|ShipmentItem newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|ShipmentItem newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|ShipmentItem query()
 * @method static \Illuminate\Database\Eloquent\Builder|ShipmentItem whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ShipmentItem whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ShipmentItem whereItemId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ShipmentItem whereQuantity($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ShipmentItem whereShipmentId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ShipmentItem whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class ShipmentItem extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    public function getTotalWeightAttribute(): ?float
    {
        if (!$this->quantity || !$this->orderItem) {
            return 0;
        }

        return $this->quantity * $this->orderItem->item->weight;
    }

    /*
   |--------------------------------------------------------------------------
   | Relationships
   |--------------------------------------------------------------------------
   */
    public function shipment(): BelongsTo
    {
        return $this->belongsTo(Shipment::class);
    }

    public function orderItem(): BelongsTo
    {
        return $this->belongsTo(OrderItem::class, 'item_id'); // TODO rename to order_item_id
    }
}
