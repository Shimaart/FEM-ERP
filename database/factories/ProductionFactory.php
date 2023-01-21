<?php

namespace Database\Factories;

use App\Models\Production;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class ProductionFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Production::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'creator_id' => User::factory(),
            'date' => $this->faker->dateTimeBetween('-1 month','+1 month'),
            'description' => $this->faker->paragraph,
            'status' => collect(Production::statuses())->random()
        ];
    }
}
