<?php

namespace Database\Factories;

use App\Models\CostItem;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class CostItemFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = CostItem::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'name' => Str::title($this->faker->word)
        ];
    }
}
