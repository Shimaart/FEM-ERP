<?php

namespace Database\Seeders;

use App\Models\Refund;
use Illuminate\Database\Seeder;

class RefundSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Refund::factory(30)->create();
    }
}
