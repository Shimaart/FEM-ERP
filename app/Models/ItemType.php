<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * App\Models\ItemType
 *
 * @property int $id
 * @property string $name
 * @property int|null $in_title
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\ItemTypeGroup[] $groups
 * @property-read int|null $groups_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\ItemTypeGroup[] $itemTypeGroups
 * @property-read int|null $item_type_groups_count
 * @method static \Illuminate\Database\Eloquent\Builder|ItemType newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|ItemType newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|ItemType query()
 * @method static \Illuminate\Database\Eloquent\Builder|ItemType whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ItemType whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ItemType whereInTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ItemType whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ItemType whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class ItemType extends Model
{
    use HasFactory;

    protected $guarded = [
        'id'
    ];

    public function itemTypeGroups(): HasMany
    {
        return $this->hasMany(ItemTypeGroup::class);
    }

    public function groups(): BelongsToMany
    {
        return $this->belongsToMany(ItemTypeGroup::class);
    }
}
