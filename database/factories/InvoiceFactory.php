<?php

namespace Database\Factories;

use App\Models\Contact;
use App\Models\Invoice;
use App\Models\Supplier;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class InvoiceFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Invoice::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'manager_id' => User::factory(),
            'supplier_id' => Supplier::factory()
                ->has(Contact::factory()->email(), 'contacts')
                ->has(Contact::factory()->phone(), 'contacts'),
            'total_amount' => $this->faker->numberBetween(1000,250000),
            'paid_amount' => $this->faker->numberBetween(1000,250000),
            'discount' => $this->faker->numberBetween(0,15),
            'status' => collect(Invoice::statuses())->random(),
        ];
    }
}
