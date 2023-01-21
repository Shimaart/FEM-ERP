<?php

namespace App\Http\Livewire\Leads;

use App\Utils;
use App\Models\Order;
use App\Models\Customer;
use App\Models\Lead;
use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Validation\Rule;
use Livewire\Component;

class LeadForm extends Component
{
    use AuthorizesRequests;

    public Lead $lead;

    public bool $managingCustomer = false;
    public bool $managingNote = false;
    public bool $changingStatusToNotResponded = false;
    public bool $changingStatusToMeasurement = false;
    public bool $changingStatusToMeasured = false;
    public bool $changingStatusToDeclined = false;

    protected $listeners = [
        'customerSelected' => 'customerSelected',
        'customerSaved' => 'customerSaved'
    ];

    public function mount(Lead $lead): void
    {
        $this->lead = $lead;
        $this->setCustomer($lead->customer ?? new Customer);
    }

    public function customerSelected($customerId): void
    {
        $this->setCustomer(Customer::query()->findOrNew($customerId));
    }

    public function customerSaved(Customer $customer): void
    {
        $this->setCustomer($customer);
        $this->managingCustomer = false;
    }

    private function setCustomer(Customer $customer)
    {
        $this->lead->customer_id = $customer->id;
        $this->lead->customer()->associate($customer);

        $this->emit('setCustomer', $customer->id);
    }

    public function getManagersProperty()
    {
        return User::query()
            ->whereIn('assigned_role', collect(Utils::findRolesByPermissions('manage any leads'))->keys())
            ->get();
    }

    public function rules(): array
    {
        return [
            'lead.customer_id' => ['nullable', 'exists:customers,id'],
            'lead.manager_id' => ['nullable', 'exists:users,id'],
            'lead.status' => ['required', Rule::in(Lead::statuses())],
            'lead.note' => ['nullable', 'string'],
            'lead.no_respond_reason' => ['required', Rule::in(Lead::noRespondReasons())],
            'lead.measurer_full_name' => ['nullable', 'string'],
            'lead.measurement_address' => ['nullable', 'string'],
            'lead.measurement_date' => ['nullable', 'date'],
            'lead.decline_reason' => ['required', Rule::in(Lead::declineReasons())],
            'lead.result' => ['nullable', 'string'],
        ];
    }

    public function updatedLeadManagerId(): void
    {
        $this->authorize('assignManager', $this->lead);
        $this->validateOnly('lead.manager_id');

        if (! $this->lead->manager_id) {
            $this->lead->manager_id = null;
            $this->lead->forceFill([
                'status' => Lead::STATUS_NEW
            ]);

        } else if ($this->lead->status === Lead::STATUS_NEW) {
            // automatically update status when manager assigned
            $this->lead->forceFill([
                'status' => Lead::STATUS_ASSIGNED
            ]);
        }

        $this->lead->save();
        $this->emitSaved();
    }

    public function saveNote(): void
    {
        $this->validateOnly('lead.note');

        $this->lead->save();

        $this->managingNote = false;
    }

    public function statusOptions(): array
    {
        return Lead::statusOptions();
    }

    public function changeStatus($status): void
    {
        $this->validateOnly('lead.status');

        if (! $this->lead->canChangeStatusTo($status)) {
            abort(400, 'Unable change to status ' . $status);
        }

        $method = 'changeStatusTo' . Str::camel($status);

        if (method_exists($this, $method)) {
            $this->$method();
        } else {
            $this->lead->forceFill([
                'status' => $status
            ])->save();
            $this->emitSaved();
        }
    }

    public function changeStatusToNew(): void
    {
        $this->authorize('assignManager', $this->lead);

        $this->lead->forceFill([
            'status' => Lead::STATUS_NEW,
            'manager_id' => null
        ])->save();
        $this->emitSaved();
    }

    public function changeStatusToAssigned(): void
    {
        $this->authorize('assignManager', $this->lead);

        // TODO
    }

    public function changeStatusToNotResponded(): void
    {
        $this->changingStatusToNotResponded = true;
    }

    public function noRespondReasonOptions(): array
    {
        return Lead::noRespondReasonOptions();
    }

    public function saveStatusNotResponded(): void
    {
        $this->validateOnly('lead.no_respond_reason');

        $this->lead->forceFill([
            'status' => Lead::STATUS_NOT_RESPONDED,
        ])->save();

        $this->emitSaved();
        $this->changingStatusToNotResponded = false;
    }

//    public function changeStatusToProcessing(): void
//    {
//
//    }

    public function changeStatusToMeasurement(): void
    {
        $this->changingStatusToMeasurement = true;
    }

    public function saveStatusMeasurement(): void
    {
        $this->validate([
            'lead.measurer_full_name' => ['required', 'string'],
            'lead.measurement_address' => ['required', 'string'],
            'lead.measurement_date' => ['required', 'date']
        ]);

        $this->lead->forceFill([
            'status' => Lead::STATUS_MEASUREMENT,
        ])->save();

        $this->emitSaved();
        $this->changingStatusToMeasurement = false;
    }

    public function changeStatusToMeasured(): void
    {
        $this->changingStatusToMeasured = true;
    }

    public function saveStatusMeasured(): void
    {
        $this->validate([
            'lead.result' => ['required', 'string']
        ]);

        $this->lead->forceFill([
            'status' => Lead::STATUS_MEASURED
        ])->save();

        $this->emitSaved();
        $this->changingStatusToMeasured = false;
    }

    public function changeStatusToAccepted(): void
    {
        if (! is_null($this->lead->order)) {
            return;
        }

        $order = $this->lead->order()->create([
            'status' => Order::STATUS_CREATED,
            'customer_id' => $this->lead->customer_id,
            'manager_id' => $this->lead->manager_id,
            'note' => $this->lead->result
        ]);

        $this->lead->forceFill([
            'order_id' => $order->id,
            'status' => Lead::STATUS_ACCEPTED,
        ])->save();

        $this->emitSaved();
        $this->emit('openInNewTab', route('orders.show', ['order' => $order->id]));
    }

    public function changeStatusToDeclined(): void
    {
        $this->changingStatusToDeclined = true;
    }

    public function declineReasonOptions(): array
    {
        return Lead::declineReasonOption();
    }

    public function saveStatusDeclined(): void
    {
        $this->validateOnly('lead.decline_reason');

        $this->lead->forceFill([
            'status' => Lead::STATUS_DECLINED,
        ])->save();

        $this->emitSaved();

        $this->changingStatusToDeclined = false;
    }

    public function changeStatusToSuccess(): void
    {
        // TODO
    }

    private function emitSaved(): void
    {
        $this->emit('leadSaved', $this->lead);
    }
}
