<?php

namespace App\Models;

use App\Concerns\HasComments;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * App\Models\Production
 *
 * @property int $id
 * @property int $creator_id
 * @property mixed|null $date
 * @property string|null $description
 * @property string $status
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Comment[] $comments
 * @property-read int|null $comments_count
 * @property-read \App\Models\User $creator
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\ProductionItem[] $productionItems
 * @property-read int|null $production_items_count
 * @method static \Illuminate\Database\Eloquent\Builder|Production newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Production newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Production query()
 * @method static \Illuminate\Database\Eloquent\Builder|Production whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Production whereCreatorId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Production whereDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Production whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Production whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Production whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Production whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class Production extends Model
{
    use HasFactory, HasComments;

    const STATUS_DRAFTED = 'drafted';
    const STATUS_CREATED = 'created';
    const STATUS_PROCESSED = 'processed';
    const STATUS_RECEIVED = 'received';

    protected $guarded = [
        'id'
    ];

    protected $casts = [
        'date' => 'date:Y-m-d'
    ];

    public static function statuses(): array
    {
        return array_keys(self::statusOptions());
    }

    public static function statusOptions(): array
    {
        return [
            self::STATUS_CREATED => __('Создан'),
            self::STATUS_PROCESSED => __('Произведен'),
            self::STATUS_RECEIVED => __('Принят'),
        ];
    }

    /*
    |--------------------------------------------------------------------------
    | Relationships
    |--------------------------------------------------------------------------
    */
    public function creator(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function productionItems(): HasMany//может назвать products??
    {
        return $this->hasMany(ProductionItem::class);
    }
}
