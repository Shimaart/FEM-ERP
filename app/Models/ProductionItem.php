<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * App\Models\ProductionItem
 *
 * @property int $id
 * @property int $production_id
 * @property int $item_id
 * @property int $need_quantity
 * @property int|null $processed_quantity
 * @property int|null $defects_count
 * @property int|null $received_quantity
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Item $item
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\ConsumedMaterial[] $materials
 * @property-read int|null $materials_count
 * @property-read \App\Models\Production $production
 * @method static \Illuminate\Database\Eloquent\Builder|ProductionItem newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|ProductionItem newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|ProductionItem query()
 * @method static \Illuminate\Database\Eloquent\Builder|ProductionItem whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ProductionItem whereDefectsCount($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ProductionItem whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ProductionItem whereItemId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ProductionItem whereNeedQuantity($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ProductionItem whereProcessedQuantity($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ProductionItem whereProductionId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ProductionItem whereReceivedQuantity($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ProductionItem whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class ProductionItem extends Model
{
    use HasFactory;

    protected $guarded = [
        'id'
    ];

    /*
    |--------------------------------------------------------------------------
    | Relationships
    |--------------------------------------------------------------------------
    */
    public function production(): BelongsTo
    {
        return $this->belongsTo(Production::class);
    }

    public function item(): BelongsTo
    {
        return $this->belongsTo(Item::class);
    }

    public function materials(): HasMany
    {
        return $this->hasMany(ConsumedMaterial::class);
    }
}
