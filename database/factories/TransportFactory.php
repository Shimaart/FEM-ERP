<?php

namespace Database\Factories;

use App\Models\Transport;
use Illuminate\Database\Eloquent\Factories\Factory;

class TransportFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Transport::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'name' => $this->faker->countryCode . ' ' . $this->faker->numberBetween(100,999) . ' ' . $this->faker->countryCode,
            'kilometer_price' => $this->faker->numberBetween(100,1000),
        ];
    }
}
