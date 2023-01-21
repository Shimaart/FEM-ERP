<?php

namespace Database\Seeders;

use App\Models\Comment;
use App\Models\Customer;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Payment;
use App\Models\Shipment;
use App\Models\ShipmentItem;
use App\Models\User;
use Illuminate\Database\Seeder;

class OrderSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $users = User::all();
        $customers = Customer::all();

        $chains = [
            [
                Order::STATUS_CREATED
            ],
            [
                Order::STATUS_CREATED,
            ],
            [
                Order::STATUS_CREATED,
                Order::STATUS_CANCELED
            ],
            [
                Order::STATUS_CREATED,
                Order::STATUS_ACTIVE
            ],
            [
                Order::STATUS_CREATED,
                Order::STATUS_ACTIVE,
                Order::STATUS_CLOSED
            ],
            [
                Order::STATUS_CREATED,
                Order::STATUS_CANCELED
            ]
        ];

        for ($i = 0; $i <= 100; $i++) {
            $order = Order::factory()
                ->create([
                    'manager_id' => $users->random()->id,
                    'customer_id' => $customers->random()->id,
                ]);

            $chain = collect($chains)->random();

            foreach ($chain as $step) {
                Comment::factory()->order()->state([
                    'author_id' => $users->random()->id,
                    'status' => $step,
                ])->create([
                    'commentable_id' => $order->id
                ]);
            }

            $order->update([
                'status' => $step
            ]);

            $items = OrderItem::factory(mt_rand(1, 4))->create([
                'order_id' => $order->id
            ]);

            $shipment = Shipment::factory()->create([
                'order_id' => $order->id
            ]);

            if ($shipment->type === Shipment::TYPE_PICKUP) {
                $shipment->update([
                    'amount' => 0,
                    'status' => Shipment::STATUS_SHIPPED
                ]);

                Comment::factory()->shipment()->create([
                    'author_id' => $users->random()->id,
                    'commentable_id' => $shipment->id,
                    'status' => Shipment::STATUS_SHIPPED
                ]);

                foreach ($items as $item) {
                    ShipmentItem::factory()->create([
                        'shipment_id' => $shipment->id,
                        'item_id' => $item->id,
                        'quantity' => $item->quantity,
                    ]);
                }

//                $table->integer('total_amount')->nullable();
//                $table->integer('paid_amount')->nullable();
//                $table->integer('discount')->nullable();
//                $table->string('status');
                if (mt_rand(1,2) % 2 === 0) {
                    $payment = Payment::factory()->create([
                        'paymentable_type' => $order->getMorphClass(),
                        'paymentable_id' => $order->id,
                        'amount' => $order->total_amount / 2,
                        'status' => Payment::STATUS_PAID
                    ]);

                    Comment::factory()->payment()->create([
                        'author_id' => $users->random()->id,
                        'commentable_id' => $payment->id,
                        'status' => Payment::STATUS_PAID,
                    ]);

                    $order->update([
                        'paid_amount' => $order->total_amount / 2
                    ]);

                    if (mt_rand(1,2) % 2 === 0) {
                        $payment = Payment::factory()->create([
                            'paymentable_type' => $order->getMorphClass(),
                            'paymentable_id' => $order->id,
                            'amount' => $order->total_amount / 2,
                            'status' => Payment::STATUS_CREATED
                        ]);

                        Comment::factory()->payment()->create([
                            'author_id' => $users->random()->id,
                            'commentable_id' => $payment->id,
                            'status' => Payment::STATUS_CREATED,
                        ]);
                    }
                } else {
                    $status = collect(Payment::statuses())->random();
                    $payment = Payment::factory()->create([
                        'paymentable_type' => $order->getMorphClass(),
                        'paymentable_id' => $order->id,
                        'amount' => $order->total_amount,
                        'status' => $status
                    ]);

                    Comment::factory()->payment()->create([
                        'author_id' => $users->random()->id,
                        'commentable_id' => $payment->id,
                        'status' => $status
                    ]);

                    if ($status === Payment::STATUS_PAID) {
                        $order->update([
                            'paid_amount' => $order->total_amount
                        ]);
                    }
                }

            } else {
                $kof = mt_rand(1, 4);
                if ($kof % 3 === 0) {
                    $stoсkValues = [];
                    foreach ($items as $item) {
                        $count = $item->quantity - mt_rand(1, $item->quantity) + 1;
                        $stoсkValues[$item->id] = $item->quantity - $count;
                        ShipmentItem::factory()->create([
                            'shipment_id' => $shipment->id,
                            'item_id' => $item->id,
                            'quantity' => $count,
                        ]);
                    }
                    Comment::factory()->shipment()->create([
                        'author_id' => $users->random()->id,
                        'commentable_id' => $shipment->id,
                        'status' => Shipment::STATUS_SHIPPED
                    ]);

                    if (mt_rand(2, 4) % 2 === 0) {
                        $anotherShipment = Shipment::factory()->create([
                            'order_id' => $order->id,
                            'type' => Shipment::TYPE_DELIVERY
                        ]);

                        foreach ($stoсkValues as $key => $value) {
                            ShipmentItem::factory()->create([
                                'shipment_id' => $anotherShipment->id,
                                'item_id' => $key,
                                'quantity' => $value,
                            ]);
                        }

                        Comment::factory()->shipment()->create([
                            'author_id' => $users->random()->id,
                            'commentable_id' => $anotherShipment->id
                        ]);
                    }
                } else {
                    foreach ($items as $item) {
                        ShipmentItem::factory()->create([
                            'shipment_id' => $shipment->id,
                            'item_id' => $item->id,
                            'quantity' => $item->quantity,
                        ]);
                    }

                    if($kof % 4 === 0) {
                        Comment::factory()->shipment()->create([
                            'author_id' => $users->random()->id,
                            'commentable_id' => $shipment->id,
                            'status' => Shipment::STATUS_CREATED
                        ]);
                    } else {
                        Comment::factory()->shipment()->create([
                            'author_id' => $users->random()->id,
                            'commentable_id' => $shipment->id,
                            'status' => Shipment::STATUS_SHIPPED
                        ]);
                    }
                }

                $status = collect(Payment::statuses())->random();
                $payment = Payment::factory()->create([
                    'paymentable_type' => $order->getMorphClass(),
                    'paymentable_id' => $order->id,
                    'amount' => $order->total_amount,
                    'status' => $status
                ]);

                Comment::factory()->payment()->create([
                    'author_id' => $users->random()->id,
                    'commentable_id' => $payment->id,
                    'status' => $status
                ]);

                if ($status === Payment::STATUS_PAID) {
                    $order->update([
                        'paid_amount' => $order->total_amount
                    ]);
                }

                $status = collect(Payment::statuses())->random();
                $payment = Payment::factory()->shipment()->create([
                    'paymentable_type' => $shipment->getMorphClass(),
                    'paymentable_id' => $shipment->id,
                    'amount' => -$shipment->amount,
                    'status' => $status
                ]);

                Comment::factory()->payment()->create([
                    'author_id' => $users->random()->id,
                    'commentable_id' => $payment->id,
                    'status' => $status
                ]);
            }

        }
    }
}
