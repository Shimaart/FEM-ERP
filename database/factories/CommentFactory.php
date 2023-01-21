<?php

namespace Database\Factories;

use App\Models\Comment;
use App\Models\Contact;
use App\Models\Invoice;
use App\Models\Order;
use App\Models\Payment;
use App\Models\Production;
use App\Models\Shipment;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class CommentFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Comment::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'author_id' => User::factory(),
            'commentable_type' => 'App\Order',
            'commentable_id' => Order::factory(),
            'type' => collect(Comment::types())->random(),
            'comment' => $this->faker->paragraph,
            'status' => collect(Order::statuses())->random()
        ];
    }

    public function invoice() {
        return $this->state([
            'commentable_type' => 'App\Invoice',
            'commentable_id' => Invoice::factory(),
            'status' => collect(Invoice::statuses())->random()
        ]);
    }

    public function order() {
        return $this->state([
            'commentable_type' => 'App\Order',
            'commentable_id' => Order::factory(),
            'status' => collect(Order::statuses())->random()
        ]);
    }

    public function payment() {
        return $this->state([
            'commentable_type' => 'App\Payment',
            'commentable_id' => Payment::factory(),
            'status' => collect(Payment::statuses())->random()
        ]);
    }

    public function production() {
        return $this->state([
            'commentable_type' => 'App\Production',
            'commentable_id' => Production::factory(),
            'status' => collect(Production::statuses())->random()
        ]);
    }

    public function shipment() {
        return $this->state([
            'commentable_type' => 'App\Shipment',
            'commentable_id' => Shipment::factory(),
            'status' => collect(Shipment::statuses())->random()
        ]);
    }
}
