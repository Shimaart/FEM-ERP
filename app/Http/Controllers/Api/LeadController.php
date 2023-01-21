<?php

namespace App\Http\Controllers\Api;

use App\Models\Contact;
use App\Models\Customer;
use App\Models\Lead;
use App\Events\LeadCreated;
use App\Http\Controllers\Controller;
use App\Http\Requests\Api\StoreLeadRequest;
use Illuminate\Database\Eloquent\Builder;

final class LeadController extends Controller
{
    public function store(StoreLeadRequest $request): Lead
    {
        // check is customer exists
        /** @var Customer $customer */
        $customer = Customer::query()
            ->whereHas('contacts', function (Builder $query) use ($request) {
                $query
                    ->where('type', '=', Contact::TYPE_PHONE_NUMBER)
                    ->whereIn('value',
                        collect($request->post('contacts'))
                            ->where('type', '=', Contact::TYPE_PHONE_NUMBER)
                            ->pluck('value')
                    );
            })->first();

        if (! $customer) {
            $customer = Customer::query()->create([
                'name' => $request->input('name')
            ]);
        }

        if (is_array($contacts = $request->post('contacts'))) {
            foreach ($request->post('contacts') as $contact) {
                $customer->contacts()->firstOrCreate($contact);
            }
        }

        /** @var Lead $lead */
        $lead = Lead::query()->create($request->only(['name', 'note', 'referrer']) + [
            'status' => Lead::STATUS_NEW,
            'customer_id' => $customer->id
        ]);

        event(new LeadCreated($lead, LeadCreated::SOURCE_API));

        return $lead->load('customer');
    }
}
