<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * App\Models\ItemAttribute
 *
 * @property int $item_id
 * @property int $group_id
 * @property int $attribute_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Attribute $attribute
 * @property-read \App\Models\AttributeGroup $group
 * @property-read \App\Models\Item $item
 * @method static \Illuminate\Database\Eloquent\Builder|ItemAttribute newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|ItemAttribute newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|ItemAttribute query()
 * @method static \Illuminate\Database\Eloquent\Builder|ItemAttribute whereAttributeId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ItemAttribute whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ItemAttribute whereGroupId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ItemAttribute whereItemId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ItemAttribute whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class ItemAttribute extends Model
{
    use HasFactory;

    protected $guarded = [
        'id'
    ];

    public function group(): BelongsTo
    {
        return $this->belongsTo(AttributeGroup::class);
    }

    public function attribute(): BelongsTo
    {
        return $this->belongsTo(Attribute::class);
    }

    public function item(): BelongsTo
    {
        return $this->belongsTo(Item::class);
    }
}
