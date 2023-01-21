<?php

namespace Database\Factories;

use App\Models\OrderItem;
use App\Models\Shipment;
use App\Models\ShipmentItem;
use Illuminate\Database\Eloquent\Factories\Factory;

class ShipmentItemFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = ShipmentItem::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'shipment_id' => Shipment::factory(),
            'item_id' => OrderItem::factory(),
            'quantity' => $this->faker->numberBetween(100, 200)
        ];
    }
}
