<?php

namespace Database\Factories;

use App\Models\Contact;
use App\Models\Customer;
use App\Models\Item;
use App\Models\Supplier;
use Illuminate\Database\Eloquent\Factories\Factory;

class ContactFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Contact::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'contactable_type' => 'App\Customer',
            'contactable_id' => Customer::factory()
        ];
    }

    public function supplier()
    {
        return [
            'contactable_type' => 'App\Supplier',
            'contactable_id' => Supplier::factory()
        ];
    }

    public function email()
    {
        return $this->state([
            'type' => Contact::TYPE_EMAIL,
            'value' => $this->faker->unique()->email
        ]);
    }

    public function phone()
    {
        return $this->state([
            'type' => Contact::TYPE_PHONE_NUMBER,
            'value' => $this->faker->unique()->phoneNumber
        ]);
    }
}
