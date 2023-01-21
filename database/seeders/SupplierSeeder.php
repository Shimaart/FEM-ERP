<?php

namespace Database\Seeders;

use App\Models\Contact;
use App\Models\Supplier;
use Illuminate\Database\Seeder;

class SupplierSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Supplier::factory(30)
            ->has(Contact::factory()->email(), 'contacts')
            ->has(Contact::factory()->phone(), 'contacts')
            ->create();
    }
}
