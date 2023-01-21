<?php

namespace Database\Factories;

use App\Models\Attribute;
use App\Models\AttributeGroup;
use App\Models\Item;
use App\Models\ItemAttribute;
use Illuminate\Database\Eloquent\Factories\Factory;

class ItemAttributeFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = ItemAttribute::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'item_id' => Item::factory(),
            'group_id' => AttributeGroup::factory(),
            'attribute_id' => Attribute::factory()
        ];
    }
}
