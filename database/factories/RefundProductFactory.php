<?php

namespace Database\Factories;

use App\Models\OrderItem;
use App\Models\Refund;
use App\Models\RefundProduct;
use Illuminate\Database\Eloquent\Factories\Factory;

class RefundProductFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = RefundProduct::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'refund_id' => Refund::factory(),
            'item_id' => OrderItem::factory(),
            'quantity' => $this->faker->numberBetween(100, 2000),
            'price' => $this->faker->numberBetween(100, 20000),
            'discount' => $this->faker->numberBetween(0, 20)
        ];
    }
}
