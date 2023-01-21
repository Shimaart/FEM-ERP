<?php

namespace Database\Factories;

use App\Models\Order;
use App\Models\Shipment;
use App\Models\Transport;
use Illuminate\Database\Eloquent\Factories\Factory;

class ShipmentFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Shipment::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'order_id' => Order::factory(),
            'transport_id' => Transport::factory(),
            'type' => collect(Shipment::types())->random(),
            'address' => $this->faker->address,
            'desired_date' => $this->faker->dateTimeBetween('-1 month','+1 month'),
            'amount' => $this->faker->numberBetween(100,1000),
            'distance' => $this->faker->numberBetween(100,1000),
            'kilometer_price' => $this->faker->numberBetween(100,1000),
            'status' => collect(Shipment::statuses())->random(),
            'created_at' => $this->faker->dateTimeBetween('-1 month','+1 month'),
        ];
    }

    public function pickup() {
        return $this->state([
            'type' => Shipment::TYPE_PICKUP
        ]);
    }

    public function delivery() {
        return $this->state([
            'type' => Shipment::TYPE_DELIVERY
        ]);
    }

    public function deliveryService() {
        return $this->state([
            'type' => Shipment::TYPE_DELIVERY_SERVICE
        ]);
    }
}
