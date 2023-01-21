<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * App\Models\AttributeGroup
 *
 * @property int $id
 * @property string $name
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Attribute[] $attributes
 * @property-read int|null $attributes_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\ItemTypeGroup[] $itemTypeGroups
 * @property-read int|null $item_type_groups_count
 * @method static \Illuminate\Database\Eloquent\Builder|AttributeGroup newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|AttributeGroup newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|AttributeGroup query()
 * @method static \Illuminate\Database\Eloquent\Builder|AttributeGroup whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AttributeGroup whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AttributeGroup whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AttributeGroup whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class AttributeGroup extends Model
{
    use HasFactory;

    protected $guarded = [
        'id'
    ];

    public function attributes(): HasMany
    {
        return $this->hasMany(Attribute::class,'group_id');
    }

    public function itemTypeGroups(): HasMany
    {
        return $this->hasMany(ItemTypeGroup::class,'group_id');
    }
}
