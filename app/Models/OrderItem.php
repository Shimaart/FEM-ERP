<?php

namespace App\Models;

use App\Concerns\HasPayments;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * App\Models\OrderItem
 *
 * @property int $id
 * @property int $order_id
 * @property int $item_id
 * @property string $quantity
 * @property string|null $price
 * @property string|null $discount
 * @property float|null $profit_percent
 * @property boolean|null $warehouse_skipped
 * @property float|null $purchase_price
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read float|null $amount
 * @property-read float|null $total_amount
 * @property-read \App\Models\Item $item
 * @property-read \App\Models\Order $order
 * @method static \Illuminate\Database\Eloquent\Builder|OrderItem newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|OrderItem newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|OrderItem query()
 * @method static \Illuminate\Database\Eloquent\Builder|OrderItem whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|OrderItem whereDiscount($value)
 * @method static \Illuminate\Database\Eloquent\Builder|OrderItem whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|OrderItem whereItemId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|OrderItem whereOrderId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|OrderItem wherePrice($value)
 * @method static \Illuminate\Database\Eloquent\Builder|OrderItem whereQuantity($value)
 * @method static \Illuminate\Database\Eloquent\Builder|OrderItem whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class OrderItem extends Model
{
    use HasFactory, HasPayments;

    protected $guarded = ['id'];

    protected $attributes = [
        'discount' => 0
    ];

    // without discount
    public function getAmountAttribute(): ?float
    {
        if (!$this->price || !$this->quantity) {
            return 0;
        }

        return $this->price * $this->quantity;
    }

    public function getTotalAmountAttribute(): ?float
    {
        $amount = $this->amount;

//        // with tax
//        if ($this->item && $this->item->itemCategory->taxable && $this->order && $this->order->has_tax) {
//            $amount = $amount + ($amount * $this->order->tax_percent / 100);
//        }

        // with tax
        if ($this->item && $this->order && $this->order->has_tax) {
            $amount = $amount + ($amount * $this->order->tax_percent / 100);
        }

        // with discount
        if ($this->discount) {
            $amount = $amount - ($amount * $this->discount / 100);
        }

        return $amount;
    }


    public function getTotalAmountWithoutTaxAttribute(): ?float
    {
        $value = 0;
        if ($this->total_amount ) {
            $value = $this->total_amount;
            if ($this->order && in_array($this->order->tax, [Order::TAX_VAT, Order::TAX_FOP])) {
                $value = $this->total_amount / (1 + $this->order->tax_percent / 100);
            }
        }

        return $value;
    }

    public function getAvailableQuantity($shipment_id): float
    {
        $countInOrderShipments = $this->shipmentItems()
            ->where('id', '!=', $shipment_id)
            ->sum('shipment_items.quantity');

        $countInStock = ShipmentItem::query()
            ->whereHas('shipment', function (Builder $query) use ($shipment_id) {
                $query->where('id', '!=', $shipment_id);
            })
            ->whereHas('orderItem', function (Builder $query) {
                $query->where('item_id', $this->item_id);
            })
            ->sum('shipment_items.quantity');

        $countResidue = min($countInStock, $countInOrderShipments);
        return (float)$this->quantity - $countResidue;
    }

    public function order(): BelongsTo
    {
        return $this->belongsTo(Order::class);
    }

    public function item(): BelongsTo
    {
        return $this->belongsTo(Item::class);
    }

    public function shipmentItems(): HasMany
    {
        return $this->hasMany(ShipmentItem::class, 'item_id');
    }
}
