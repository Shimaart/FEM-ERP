<?php

namespace Database\Factories;

use App\Models\Contact;
use App\Models\Customer;
use App\Models\Order;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class OrderFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Order::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'manager_id' => User::factory(),
            'customer_id' => Customer::factory()
                ->has(Contact::factory()->email(), 'contacts')
                ->has(Contact::factory()->phone(), 'contacts'),
            'total_amount' => $this->faker->numberBetween(1000,250000),
            'paid_amount' => $this->faker->numberBetween(1000,250000),
            'discount' => $this->faker->numberBetween(0,15),
            'status' => collect(Order::statuses())->random(),
        ];
    }
}
