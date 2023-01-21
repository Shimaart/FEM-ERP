<?php

namespace Database\Factories;

use App\Models\ConsumedMaterial;
use App\Models\Item;
use App\Models\ProductionItem;
use Illuminate\Database\Eloquent\Factories\Factory;

class ConsumedMaterialFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = ConsumedMaterial::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'production_item_id' => ProductionItem::factory(),
            'material_id' => Item::factory()->material(),
            'value' => $this->faker->numberBetween(100, 500)
        ];
    }
}
