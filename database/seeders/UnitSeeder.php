<?php

namespace Database\Seeders;

use App\Models\Unit;
use Illuminate\Database\Seeder;

class UnitSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Unit::factory()->create([
            'label' => 'Метры квадратные',
            'symbol' => 'м²',
        ]);

        Unit::factory()->create([
            'label' => 'Метры кубические',
            'symbol' => 'м³',
        ]);

        Unit::factory()->create([
            'label' => 'Штуки',
            'symbol' => 'шт',
        ]);

        Unit::factory()->create([
            'label' => 'Килограммы',
            'symbol' => 'кг',
        ]);

        Unit::factory()->create([
            'label' => 'Тонны',
            'symbol' => 'т',
        ]);
    }
}
