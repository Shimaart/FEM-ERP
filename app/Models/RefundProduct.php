<?php

namespace App\Models;

use App\Concerns\HasPayments;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * App\Models\RefundProduct
 *
 * @property int $id
 * @property int $refund_id
 * @property int $item_id
 * @property string $quantity
 * @property string|null $price
 * @property string|null $discount
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\OrderItem $orderItem
 * @property-read \App\Models\Refund $refund
 * @method static \Illuminate\Database\Eloquent\Builder|RefundProduct newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|RefundProduct newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|RefundProduct query()
 * @method static \Illuminate\Database\Eloquent\Builder|RefundProduct whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|RefundProduct whereDiscount($value)
 * @method static \Illuminate\Database\Eloquent\Builder|RefundProduct whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|RefundProduct whereItemId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|RefundProduct wherePrice($value)
 * @method static \Illuminate\Database\Eloquent\Builder|RefundProduct whereQuantity($value)
 * @method static \Illuminate\Database\Eloquent\Builder|RefundProduct whereRefundId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|RefundProduct whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class RefundProduct extends Model
{
    use HasFactory, HasPayments;


    protected $guarded = ['id'];

    /*
    |--------------------------------------------------------------------------
    | Relationships
    |--------------------------------------------------------------------------
    */
    public function refund(): BelongsTo
    {
        return $this->belongsTo(Refund::class);
    }

    public function orderItem(): BelongsTo
    {
        return $this->belongsTo(OrderItem::class, 'item_id');
    }
}
