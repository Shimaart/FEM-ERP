<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * App\Models\ItemCategory
 *
 * @property int $id
 * @property string $name
 * @property string $slug
 * @property bool $taxable
 * @property int $display_in_items
 * @property int $display_in_orders
 * @property int|null $sort
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|ItemCategory newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|ItemCategory newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|ItemCategory query()
 * @method static \Illuminate\Database\Eloquent\Builder|ItemCategory whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ItemCategory whereDisplayInItems($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ItemCategory whereDisplayInOrders($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ItemCategory whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ItemCategory whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ItemCategory whereSlug($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ItemCategory whereSort($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ItemCategory whereTaxable($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ItemCategory whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class ItemCategory extends Model
{
    use HasFactory;

    const SLUG_OWN = 'own';
    const SLUG_DEALER = 'dealer';
    const SLUG_MATERIAL = 'material';
    const SLUG_SERVICE = 'service';
    const SLUG_PALLETS = 'pallets';

    protected $guarded = ['id'];

    /**
     * The model's default values for attributes.
     *
     * @var array
     */
    protected $attributes = [
        'display_in_items' => false,
        'display_in_orders' => false,
    ];

    protected $casts = [
        'taxable' => 'boolean'
    ];

    public function items(): HasMany
    {
        return $this->hasMany(Item::class, 'category_id');
    }
}
