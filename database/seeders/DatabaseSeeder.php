<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        User::factory()->create([
            'name' => 'Dmitry',
            'email' => 'deathburger777@gmail.com'
        ]);

        User::factory()->create([
            'name' => 'Vadim',
            'email' => 'vadosrob@gmail.com'
        ]);

        User::factory()->create([
            'name' => 'Oleg',
            'email' => 'cerisemusic555@gmail.com'
        ]);

        User::factory(30)->create();

        $this->call(UnitSeeder::class);
        $this->call(AttributeSeeder::class);
        $this->call(ItemSeeder::class);

        $this->call(ProductionSeeder::class);

        $this->call(CustomerSeeder::class);//??????????
        $this->call(OrderSeeder::class);

        $this->call(RefundSeeder::class);

        $this->call(SupplierSeeder::class);
        $this->call(InvoiceSeeder::class);

        $this->call(CostItemsSeeder::class);
    }
}
