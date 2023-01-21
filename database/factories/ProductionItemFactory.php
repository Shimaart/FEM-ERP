<?php

namespace Database\Factories;

use App\Models\Item;
use App\Models\Production;
use App\Models\ProductionItem;
use Illuminate\Database\Eloquent\Factories\Factory;

class ProductionItemFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = ProductionItem::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'production_id' => Production::factory(),
            'item_id' => Item::factory()->ownProduct(),
            'need_quantity' => $this->faker->numberBetween(100, 200),
            'processed_quantity' => $this->faker->numberBetween(100, 200),
            'defects_count' => $this->faker->numberBetween(0, 20),
            'received_quantity' => $this->faker->numberBetween(100, 200)
        ];
    }
}
