<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * App\Models\ItemTypeGroup
 *
 * @property int $id
 * @property int $item_type_id
 * @property int $group_id
 * @property int|null $sort
 * @property int|null $is_main
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\AttributeGroup $group
 * @method static \Illuminate\Database\Eloquent\Builder|ItemTypeGroup newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|ItemTypeGroup newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|ItemTypeGroup query()
 * @method static \Illuminate\Database\Eloquent\Builder|ItemTypeGroup whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ItemTypeGroup whereGroupId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ItemTypeGroup whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ItemTypeGroup whereIsMain($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ItemTypeGroup whereItemTypeId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ItemTypeGroup whereSort($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ItemTypeGroup whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class ItemTypeGroup extends Model
{
    use HasFactory;

    protected $guarded = [
        'id'
    ];

    public function group(): BelongsTo
    {
        return $this->belongsTo(AttributeGroup::class, 'group_id');
    }
}
