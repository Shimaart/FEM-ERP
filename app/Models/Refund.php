<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * App\Models\Refund
 *
 * @property int $id
 * @property int $manager_id
 * @property int $order_id
 * @property string $type
 * @property string $amount
 * @property string $comment
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\User $manager
 * @property-read \App\Models\Order $order
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\RefundProduct[] $products
 * @property-read int|null $products_count
 * @method static \Illuminate\Database\Eloquent\Builder|Refund newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Refund newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Refund query()
 * @method static \Illuminate\Database\Eloquent\Builder|Refund whereAmount($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Refund whereComment($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Refund whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Refund whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Refund whereManagerId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Refund whereOrderId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Refund whereType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Refund whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class Refund extends Model
{
    use HasFactory;

    /**
     * @deprecated
     */
    const TYPE_PALLET = 'pallet';
    /**
     * @deprecated
     */
    const TYPE_ITEMS = 'items';
    /**
     * @deprecated
     */
    const TYPE_DEFECTS = 'defects';

    protected $guarded = ['id'];

    protected $attributes = [
        'comment' => '',
        'type' => self::TYPE_ITEMS
    ];

    /**
     * @deprecated
     */
    public static function types(): array
    {
        return [
            self::TYPE_PALLET,
            self::TYPE_ITEMS,
            self::TYPE_DEFECTS
        ];
    }

    public function order(): BelongsTo
    {
        return $this->belongsTo(Order::class);
    }

    public function manager(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function products(): HasMany
    {
        return $this->hasMany(RefundProduct::class);
    }
}
