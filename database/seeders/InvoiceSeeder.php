<?php

namespace Database\Seeders;

use App\Models\Comment;
use App\Models\Invoice;
use App\Models\InvoiceItem;
use App\Models\Payment;
use App\Models\Supplier;
use App\Models\User;
use Illuminate\Database\Seeder;

class InvoiceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $users = User::all();
        $suppliers = Supplier::all();

        Invoice::factory(30)->create();

        $chains = [
            [
                Invoice::STATUS_CREATED
            ],
            [
                Invoice::STATUS_CREATED,
                Invoice::STATUS_CANCELED
            ],
            [
                Invoice::STATUS_CREATED,
                Invoice::STATUS_INVOICED
            ],
            [
                Invoice::STATUS_CREATED,
                Invoice::STATUS_INVOICED,
                Invoice::STATUS_CLOSED
            ],
            [
                Invoice::STATUS_CREATED,
                Invoice::STATUS_INVOICED,
                Invoice::STATUS_CANCELED
            ]
        ];

        for ($i = 0; $i <= 100; $i++) {
            $invoice = Invoice::factory()
                ->create([
                    'manager_id' => $users->random()->id,
                    'supplier_id' => $suppliers->random()->id,
                ]);

            $chain = collect($chains)->random();

            foreach ($chain as $step) {
                Comment::factory()->invoice()->state([
                    'author_id' => $users->random()->id,
                    'status' => $step,
                ])->create([
                    'commentable_id' => $invoice->id
                ]);
            }

            $invoice->update([
                'status' => $step
            ]);

            $items = InvoiceItem::factory(mt_rand(1, 4))->create([
                'invoice_id' => $invoice->id
            ]);


            if (mt_rand(1,2) % 2 === 0) {
                $payment = Payment::factory()->invoice()->create([
                    'paymentable_type' => $invoice->getMorphClass(),
                    'paymentable_id' => $invoice->id,
                    'amount' => $invoice->total_amount / 2,
                    'status' => Payment::STATUS_PAID
                ]);

                Comment::factory()->payment()->create([
                    'author_id' => $users->random()->id,
                    'commentable_id' => $payment->id,
                    'status' => Payment::STATUS_PAID,
                ]);

                $invoice->update([
                    'paid_amount' => $invoice->total_amount / 2
                ]);

                if (mt_rand(1,2) % 2 === 0) {
                    $payment = Payment::factory()->invoice()->create([
                        'paymentable_type' => $invoice->getMorphClass(),
                        'paymentable_id' => $invoice->id,
                        'amount' => $invoice->total_amount / 2,
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
                $payment = Payment::factory()->invoice()->create([
                    'paymentable_type' => $invoice->getMorphClass(),
                    'paymentable_id' => $invoice->id,
                    'amount' => $invoice->total_amount,
                    'status' => $status
                ]);

                Comment::factory()->payment()->create([
                    'author_id' => $users->random()->id,
                    'commentable_id' => $payment->id,
                    'status' => $status
                ]);

                if ($status === Payment::STATUS_PAID) {
                    $invoice->update([
                        'paid_amount' => $invoice->total_amount
                    ]);
                }
            }
        }
    }
}
