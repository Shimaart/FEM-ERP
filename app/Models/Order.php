<?php

namespace App\Models;

use App\Concerns\HasComments;
use App\Concerns\HasPayments;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Support\Str;

/**
 * App\Models\Order
 *
 * @property int $id
 * @property int $manager_id
 * @property int|null $customer_id
 * @property float $total_amount
 * @property float $paid_amount
 * @property float|null $discount
 * @property string $tax
 * @property string $status
 * @property string|null $note
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Comment[] $comments
 * @property-read int|null $comments_count
 * @property-read \App\Models\Customer|null $customer
 * @property-read bool $has_tax
 * @property-read string $number
 * @property-read string $tax_label
 * @property float $tax_percent
 * @property-read \App\Models\User $manager
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\OrderItem[] $orderItems
 * @property-read int|null $order_items_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Payment[] $payments
 * @property-read int|null $payments_count
 * @property-read string|null $payment_type
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Refund[] $refunds
 * @property-read int|null $refunds_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Shipment[] $shipments
 * @property-read int|null $shipments_count
 * @method static Builder|Order byStatus(string $status)
 * @method static Builder|Order newModelQuery()
 * @method static Builder|Order newQuery()
 * @method static Builder|Order query()
 * @method static Builder|Order whereCreatedAt($value)
 * @method static Builder|Order whereCustomerId($value)
 * @method static Builder|Order whereDiscount($value)
 * @method static Builder|Order whereId($value)
 * @method static Builder|Order whereManagerId($value)
 * @method static Builder|Order whereNote($value)
 * @method static Builder|Order wherePaidAmount($value)
 * @method static Builder|Order whereStatus($value)
 * @method static Builder|Order whereTax($value)
 * @method static Builder|Order whereTotalAmount($value)
 * @method static Builder|Order whereUpdatedAt($value)
 * @mixin \Eloquent
 * @property-read \App\Models\Lead|null $lead
 * @property float|null $discount_amount
 * @method static Builder|Order whereDiscountAmount($value)
 */
class Order extends Model
{
    use HasFactory, HasPayments, HasComments;

    const STATUS_DRAFTED = 'drafted';
    const STATUS_CREATED = 'created';
    const STATUS_ACTIVE = 'active';
    const STATUS_CLOSED = 'closed';
    const STATUS_READY = 'ready';
    const STATUS_SHIPPED = 'shipped';
    const STATUS_CANCELED = 'canceled';

    const TAX_VAT = 'vat';
    const TAX_FOP = 'fop';
    const TAX_CASH = 'cash';

    protected $guarded = ['id'];

    protected $attributes = [
        'status' => self::STATUS_DRAFTED,
        'tax' => self::TAX_CASH
    ];

    public static function statuses(): array
    {
        return array_keys(static::statusOptions());
    }

    public static function statusOptions(): array
    {
        return [
            self::STATUS_DRAFTED => __('Черновик'),
            self::STATUS_CREATED => __('Просчет сметы'),
            self::STATUS_ACTIVE => __('В работе'),
            self::STATUS_CLOSED => __('Закрыт'),
            self::STATUS_READY => __('Готов к отгрузке'),
            self::STATUS_SHIPPED => __('Отгружен'),
            self::STATUS_CANCELED => __('Архив')
        ];
    }

    public static function taxes(): array
    {
        return array_keys(static::taxOptions());
    }

    public static function taxOptions(): array
    {
        return [
            self::TAX_VAT => 'НДС',
            self::TAX_FOP => 'ФОП',
            self::TAX_CASH => 'НАЛ'
        ];
    }

    public static function taxLabel($tax): string
    {
        return self::taxOptions()[$tax] ?? '';
    }

    public static function defaultTaxPercent($tax)
    {
        switch ($tax) {
            case self::TAX_VAT:
                $result = 20;
                break;
            case self::TAX_FOP:
                $result = 5;
                break;
            case self::TAX_CASH:
                $result = 0;
                break;
            default:
                $result = 0;
        }

        return $result;
    }

    public function getNumberAttribute(): string
    {
        return Str::padLeft($this->id, 8, 0);
    }

    public function getTotalAmountAttribute(): float
    {
        return $this->attributes['total_amount'] ?? 0;
    }

    public function getPaidAmountAttribute(): float
    {
        return $this->attributes['paid_amount'] ?? 0;
    }

    public function getDiscountAmountAttribute(): float
    {
//        dd(gettype($this->attributes['discount_amount']));
        return (float)$this->attributes['discount_amount'] ?? 0;
    }

    public function getTaxLabelAttribute(): string
    {
        return self::taxLabel($this->attributes['tax']);
    }

    public function getHasTaxAttribute(): bool
    {
        return in_array($this->attributes['tax'], [self::TAX_VAT, self::TAX_FOP]);
    }

    public function getPaymentTypeAttribute():string
    {
        return in_array($this->attributes['tax'], [self::TAX_VAT, self::TAX_FOP]) ? Payment::PAYMENT_TYPE_CASHLESS : Payment::PAYMENT_TYPE_CASH;
    }

//    public function getTaxPercentAttribute(): float
//    {
//        return $this->has_tax ? 20 : 0;
//    }

    public function refreshTotalAmount(): self
    {
        $orderItemsTotal = $this->orderItems->sum('total_amount');
        $shipmentsTotal = $this->shipments->reduce(function ($total, Shipment $shipment) {
            return $total + ($shipment->paid_by_order ? $shipment->total_amount : 0);
        }, 0);
        $refundsTotal = $this->refunds->sum('amount');
        $discountTotal = $this->discount_amount;

        $totalAmount = $orderItemsTotal + $shipmentsTotal - $refundsTotal - $discountTotal;
//        if (in_array($this->attributes['tax'], [self::TAX_VAT, self::TAX_FOP])) {
//            $totalAmount = $totalAmount + $totalAmount * $this->tax_percent / 100;
//        }

        return $this->forceFill([
            'total_amount' => $totalAmount
        ]);
    }

    public function refreshPaidAmount(): self
    {
        return $this->forceFill([
            'paid_amount' => $this->payments->sum('amount')
        ]);
    }

    /*
    |--------------------------------------------------------------------------
    | Scopes
    |--------------------------------------------------------------------------
    */

    public function scopeByStatus(Builder $query, string $status): Builder
    {
        return $query->where('status', '=', $status);
    }

    /*
    |--------------------------------------------------------------------------
    | Relationships
    |--------------------------------------------------------------------------
    */
    public function manager(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function customer(): BelongsTo
    {
        return $this->belongsTo(Customer::class);
    }

    public function orderItems(): HasMany
    {
        return $this->hasMany(OrderItem::class);
    }

    public function shipments(): HasMany
    {
        return $this->hasMany(Shipment::class);
    }

    public function refunds(): HasMany
    {
        return $this->hasMany(Refund::class);
    }

    public function lead(): HasOne
    {
        return $this->hasOne(Lead::class);
    }

    public function getPayableAmount(): ?float
    {
        return $this->total_amount ?? 0;
    }

    public function getPayableWithoutTaxAmount(): ?float
    {
        $value = 0;
        if ($this->total_amount ) {
            $value = $this->total_amount;
            if (in_array($this->attributes['tax'], [self::TAX_VAT, self::TAX_FOP])) {
                $value = $this->total_amount / (1 + $this->tax_percent / 100);
            }
        }

        return $value;
    }

    public function makeConsumptions()
    {
        $orderItems = $this->orderItems()
            ->whereNotNull('order_items.profit_percent')
            ->get();
        foreach ($orderItems as $orderItem) {
            $consumption = $orderItem->total_amount - $orderItem->total_amount * $orderItem->profit_percent / 100;

            $orderItem->payments()->create([
                'amount' => -$consumption,
                'payment_type' => $orderItem->order->payment_type,
                'currency' => 'UAH',
                'status' => Payment::STATUS_CREATED
            ]);
        }

        $shipments = $this->shipments()
            ->whereNotNull('shipments.profit_percent')
            ->get();

        foreach ($shipments as $shipment) {
            $consumption = $shipment->amount - $shipment->amount * $shipment->profit_percent / 100;

            $shipment->payments()->create([
                'amount' => -$consumption,
                'payment_type' => $orderItem->order->payment_type,
                'currency' => 'UAH',
                'status' => Payment::STATUS_CREATED
            ]);
        }
    }
}
