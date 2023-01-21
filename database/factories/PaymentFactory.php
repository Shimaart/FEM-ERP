<?php

namespace Database\Factories;

use App\Models\Contact;
use App\Models\Invoice;
use App\Models\Order;
use App\Models\Payment;
use App\Models\Shipment;
use Illuminate\Database\Eloquent\Factories\Factory;

class PaymentFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Payment::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'paymentable_type' => 'App\Order',
            'paymentable_id' => Order::factory(),
            'payment_type' => collect(Payment::paymentTypes())->random(),
            'currency' => 'UAH',
            'amount' => $this->faker->numberBetween(1000, 100000),
            'paid_at' => $this->faker->dateTimeBetween('-2 years'),
            'status' => collect(Payment::statuses())->random()
        ];
    }

    public function shipment() {
        return $this->state([
            'paymentable_type' => 'App\Shipment',
            'paymentable_id' => Shipment::factory()
        ]);
    }

    public function invoice() {
        return $this->state([
            'paymentable_type' => 'App\Invoice',
            'paymentable_id' => Invoice::factory()
        ]);
    }
}
