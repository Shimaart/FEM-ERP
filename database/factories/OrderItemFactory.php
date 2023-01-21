<?php

namespace Database\Factories;

use App\Models\Item;
use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Database\Eloquent\Factories\Factory;

class OrderItemFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = OrderItem::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'order_id' => Order::factory(),
            'item_id' => function () {
                $kof = mt_rand(1,3);
                if ($kof % 3 === 0) {
                    $item = Item::factory()->service();
                } elseif ($kof % 2 === 0) {
                    $item = Item::factory()->dealerProduct();
                } else {
                    $item = Item::factory()->ownProduct();
                }
                return $item;
            },
            'quantity' => $this->faker->numberBetween(100, 2000),
            'price' => $this->faker->numberBetween(100, 20000),
            'discount' => $this->faker->numberBetween(0, 20)
        ];
    }
}
