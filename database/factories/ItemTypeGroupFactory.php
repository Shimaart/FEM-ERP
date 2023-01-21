<?php

namespace Database\Factories;

use App\Models\AttributeGroup;
use App\Models\ItemType;
use App\Models\ItemTypeGroup;
use Illuminate\Database\Eloquent\Factories\Factory;

class ItemTypeGroupFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = ItemTypeGroup::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'item_type_id' => ItemType::factory(),
            'group_id' => AttributeGroup::factory(),
            'is_main' => $this->faker->boolean,
            'sort' => $this->faker->numberBetween(1,100)
        ];
    }
}
