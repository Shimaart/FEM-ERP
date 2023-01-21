<?php

namespace App\Models;

use App\Concerns\HasComments;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\MorphTo;
use Illuminate\Support\Str;

/**
 * App\Models\Payment
 *
 * @property int $id
 * @property string $paymentable_type
 * @property int $paymentable_id
 * @property string $payment_type
 * @property string $amount
 * @property string|null $currency
 * @property string $status
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Comment[] $comments
 * @property-read int|null $comments_count
 * @property-read string $number
 * @property-read string $payment_type_label
 * @property-read Model|\Eloquent $paymentable
 * @method static \Illuminate\Database\Eloquent\Builder|Payment newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Payment newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Payment query()
 * @method static \Illuminate\Database\Eloquent\Builder|Payment whereAmount($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Payment whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Payment whereCurrency($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Payment whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Payment wherePaymentType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Payment wherePaymentableId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Payment wherePaymentableType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Payment whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Payment whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class Payment extends Model
{
    use HasFactory, HasComments;

    const PAYMENT_TYPE_CASH = 'cash';
    const PAYMENT_TYPE_CASHLESS = 'cashless';

    const STATUS_CREATED = 'created';
    const STATUS_PAID = 'paid';

    protected $guarded = ['id'];

    public function getNumberAttribute(): string
    {
        return Str::padLeft($this->id, 8, 0);
    }

    public static function paymentTypes(): array
    {
        return array_keys(self::paymentTypeOptions());
    }

    public static function paymentTypeOptions(): array
    {
        return [
            self::PAYMENT_TYPE_CASH => __('Наличный рассчет'),
            self::PAYMENT_TYPE_CASHLESS => __('Безналичный рассчет')
        ];
    }

    public static function statuses(): array
    {
        return array_keys(self::statusOptions());
    }

    public static function statusOptions(): array
    {
        return [
            self::STATUS_CREATED => __('Создан'),
            self::STATUS_PAID => __('Оплачен')
        ];
    }

    public static function paymentTypeLabel($type): string
    {
        return self::paymentTypeOptions()[$type] ?? '';
    }

    public function getPaymentTypeLabelAttribute(): string
    {
        return self::paymentTypeLabel($this->payment_type);
    }

    public function getAbsAmountAttribute()
    {
        return abs($this->amount);
    }

    public function paymentable(): MorphTo
    {
        return $this->morphTo();
    }

    public function paymentMaterial(): HasOne
    {
        $this->hasOne(PaymentMaterial::class);
    }

    public function scopeIncome(Builder $query): Builder
    {
        return $query->where('amount', '>', 0);
    }

    public function scopeExpense(Builder $query): Builder
    {
        return $query->where('amount', '<', 0);
    }
}
