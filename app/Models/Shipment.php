<?php

namespace App\Models;

use App\Concerns\HasComments;
use App\Concerns\HasPayments;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * App\Models\Shipment
 *
 * @property int $id
 * @property int $order_id
 * @property int|null $transport_id
 * @property string $type
 * @property string|null $address
 * @property mixed|null $desired_date
 * @property float|null $amount
 * @property float|null $profit_percent
 * @property bool $paid_by_order
 * @property string|null $distance
 * @property string|null $kilometer_price
 * @property string $status
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Comment[] $comments
 * @property-read int|null $comments_count
 * @property-read string|null $number
 * @property-read float|null $total_amount
 * @property-read mixed $total_weight
 * @property-read \App\Models\Order $order
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Payment[] $payments
 * @property-read int|null $payments_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\ShipmentItem[] $shipmentItems
 * @property-read int|null $shipment_items_count
 * @property-read \App\Models\Transport|null $transport
 * @method static Builder|Shipment byStatus(string $status)
 * @method static Builder|Shipment newModelQuery()
 * @method static Builder|Shipment newQuery()
 * @method static Builder|Shipment query()
 * @method static Builder|Shipment whereAddress($value)
 * @method static Builder|Shipment whereAmount($value)
 * @method static Builder|Shipment whereCreatedAt($value)
 * @method static Builder|Shipment whereDesiredDate($value)
 * @method static Builder|Shipment whereDistance($value)
 * @method static Builder|Shipment whereId($value)
 * @method static Builder|Shipment whereKilometerPrice($value)
 * @method static Builder|Shipment whereOrderId($value)
 * @method static Builder|Shipment wherePaidByOrder($value)
 * @method static Builder|Shipment whereStatus($value)
 * @method static Builder|Shipment whereTransportId($value)
 * @method static Builder|Shipment whereType($value)
 * @method static Builder|Shipment whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class Shipment extends Model
{
    use HasFactory, HasPayments, HasComments;

    const TYPE_PICKUP = 'pickup';
    const TYPE_DELIVERY = 'delivery';
    const TYPE_DELIVERY_SERVICE = 'delivery_service';

    const STATUS_CREATED = 'created';
    const STATUS_SHIPPED = 'shipped';
    const STATUS_DELIVERED = 'delivered';

    protected $guarded = ['id'];

    protected $attributes = [
        'status' => Shipment::STATUS_CREATED,
        'paid_by_order' => true
    ];

    protected $casts = [
        'desired_date' => 'date:Y-m-d',
        'amount' => 'float',
        'paid_by_order' => 'boolean'
    ];

    public function getNumberAttribute(): ?string
    {
        return (string)$this->id;
    }

    public function getTotalAmountAttribute(): ?float
    {
        return $this->amount;
    }

    public function getTotalWeightAttribute()
    {
        return $this->shipmentItems->sum('total_weight');
    }

    public static function types(): array
    {
        return array_keys(self::typeOptions());
    }

    public static function typeOptions(): array
    {
        return [
            Shipment::TYPE_DELIVERY => __('Транспорт компании'),
            Shipment::TYPE_DELIVERY_SERVICE => __('Служба доставки'),
            Shipment::TYPE_PICKUP => __('Самовывоз'),
        ];
    }

    public static function statuses(): array
    {
        return array_keys(static::statusOptions());
    }

    public static function statusOptions(): array
    {
        return [
            self::STATUS_CREATED => __('Новый'),
            self::STATUS_SHIPPED => __('Отгружен'),
            self::STATUS_DELIVERED => __('Доставлен')
        ];
    }

    public function scopeByStatus(Builder $query, string $status): Builder
    {
        return $query->where('status', '=', $status);
    }

    public function getPayableAmount(): ?float
    {
        return $this->amount;
    }

    public function order(): BelongsTo
    {
        return $this->belongsTo(Order::class);
    }

    public function shipmentItems(): HasMany
    {
        return $this->hasMany(ShipmentItem::class);
    }

    public function transport(): BelongsTo
    {
        return $this->belongsTo(Transport::class);
    }
}
