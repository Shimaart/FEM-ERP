<?php

namespace Database\Factories;

use App\Models\Invoice;
use App\Models\InvoiceItem;
use App\Models\Item;
use Illuminate\Database\Eloquent\Factories\Factory;

class InvoiceItemFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = InvoiceItem::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'invoice_id' => Invoice::factory(),
            'item_id' => function () {
                $kof = mt_rand(1,2);
                if ($kof % 2 === 0) {
                    $item = Item::factory()->material();
                } else {
                    $item = Item::factory()->ownProduct();
                }
                return $item;
            },
            'quantity' => $this->faker->numberBetween(100, 2000),
            'price' => $this->faker->numberBetween(100, 20000)
        ];
    }
}
