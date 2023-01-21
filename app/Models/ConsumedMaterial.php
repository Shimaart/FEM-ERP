<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * App\Models\ConsumedMaterial
 *
 * @property int $id
 * @property int $production_item_id
 * @property int $material_id
 * @property float|null $value
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Item $material
 * @property-read \App\Models\ProductionItem $productionItem
 * @method static \Illuminate\Database\Eloquent\Builder|ConsumedMaterial newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|ConsumedMaterial newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|ConsumedMaterial query()
 * @method static \Illuminate\Database\Eloquent\Builder|ConsumedMaterial whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ConsumedMaterial whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ConsumedMaterial whereMaterialId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ConsumedMaterial whereProductionItemId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ConsumedMaterial whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ConsumedMaterial whereValue($value)
 * @mixin \Eloquent
 */
class ConsumedMaterial extends Model
{
    use HasFactory;

    protected $guarded = [
        'id'
    ];

    protected $casts = [
        'value' => 'float'
    ];

    /*
    |--------------------------------------------------------------------------
    | Relationships
    |--------------------------------------------------------------------------
    */
    public function productionItem(): BelongsTo
    {
        return $this->belongsTo(ProductionItem::class);
    }

    public function material(): BelongsTo
    {
        return $this->belongsTo(Item::class);
    }
}
