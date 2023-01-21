<?php

namespace Database\Factories;

use App\Models\ItemCategory;
use Illuminate\Database\Eloquent\Factories\Factory;

class ItemCategoryFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = ItemCategory::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'name' => $this->faker->word,
            'slug' => $this->faker->word,
            'display_in_items' => $this->faker->boolean,
            'display_in_orders' => $this->faker->boolean,
            'sort' => $this->faker->numberBetween(1,100)
        ];
    }
}
