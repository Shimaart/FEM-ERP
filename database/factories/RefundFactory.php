<?php

namespace Database\Factories;

use App\Models\Order;
use App\Models\Refund;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class RefundFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Refund::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'manager_id' => User::factory(),
            'order_id' => Order::factory(),
            'type' => collect(Refund::types())->random(),
            'amount' => $this->faker->numberBetween(1000,250000),
            'comment' => $this->faker->numberBetween(1000,250000)
        ];
    }
}
