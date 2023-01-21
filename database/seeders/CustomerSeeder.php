<?php

namespace Database\Seeders;

use App\Models\Contact;
use App\Models\Customer;
use Illuminate\Database\Seeder;

class CustomerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Customer::factory(30)
            ->has(Contact::factory()->email(), 'contacts')
            ->has(Contact::factory()->phone(), 'contacts')
            ->create();
    }
}
