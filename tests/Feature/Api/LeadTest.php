<?php

namespace Tests\Feature\Api;

use App\Models\Contact;
use App\Models\Customer;
use App\Models\Lead;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class LeadTest extends TestCase
{
    use RefreshDatabase;

    public function testGuestCanStore(): void
    {
//        $customer = Customer::factory()->create();
//        $customer->contacts()->create([
//            'type' => Contact::TYPE_PHONE_NUMBER,
//            'value' => 911
//        ]);

//        $this->postJson('/api/leads', [
//            'name' => 'Вася Пупкин',
//            'contacts' => [
//                [
//                    'type' => 'phone',
//                    'value' => '911'
//                ],
//                [
//                    'type' => 'email',
//                    'value' => 'kek@kek.kek'
//                ]
//            ],
//            'note' => 'На заметочку'
//        ])->assertCreated();
//
//        $lead = Lead::query()->latest()->first();
//
//        $this->assertEquals('Вася Пупкин', $lead->name);
//        $this->assertEquals('На заметочку', $lead->note);
//        $this->assertEquals('911', $lead->contacts->where('type' , '=', 'phone')->first()->value);
//        $this->assertEquals('kek@kek.kek', $lead->contacts->where('type' , '=', 'email')->first()->value);

//        $this->assertEquals($customer->id, $lead->customer_id);
    }

    public function testGuestCanNotCreateWithoutRequiredFields(): void
    {
        $this->postJson('/api/leads')->assertJsonValidationErrors(['name']);
    }
}
