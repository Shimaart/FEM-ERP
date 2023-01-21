<div>
    <form wire:submit.prevent="submit">
        <div class="shadow sm:rounded-md">
            <div class="px-4 py-5 bg-white sm:p-6 sm:rounded-md">
                <div class="grid grid-cols-6 gap-6">

                    <!-- Customer -->
                    <div class="col-span-6 sm:col-span-2">
                        <x-jet-label for="customer_id" value="{{ __('Контрагент') }}" />
                        <div class="flex justify-content-between items-center">
                            <livewire:customers.customer-select :value="$lead->customer_id" :placeholder="__('Новый контрагент')" />
                            <button type="button" wire:click="$set('managingCustomer', true)" class="cursor-pointer ml-2">
                                <x-heroicon-o-pencil class="w-5 h-5" />
                            </button>
                        </div>
                        <x-jet-input-error for="lead.customer_id" class="mt-2" />
                    </div>

                    <!-- Manager -->
                    <div class="col-span-6 sm:col-span-2">
                        <x-jet-label for="manager_id" value="{{ __('Менеджер') }}" />
                        @can('assignManager', $lead)
                            <select class="form-input rounded-md shadow-sm block w-full" wire:model="lead.manager_id">
                                <option value="">{{ __('Не присвоен') }}</option>
                                @foreach($this->managers as $manager)
                                    <option value="{{ $manager->id }}">{{ $manager->name }}</option>
                                @endforeach
                            </select>
                        @else
                            <x-jet-input type="text" class="block w-full" value="{{ $lead->manager ? $lead->manager->name : null }}" disabled />
                        @endif
                        <x-jet-input-error for="lead.manager_id" class="mt-2" />
                    </div>

                    <!-- Status -->
                    <div class="col-span-6 sm:col-span-2">
                        <x-jet-label for="status" value="{{ __('Статус') }}" />
                        <div class="flex justify-content-between items-center">
                            <x-jet-input type="text" class="block w-full" value="{{ $lead->status_label }}" disabled />
                            <div class="ml-3 relative">
                                <x-jet-dropdown align="right" width="60">
                                    <x-slot name="trigger">
                                        <x-heroicon-o-selector class="cursor-pointer w-5 h-5" />
                                    </x-slot>

                                    <x-slot name="content">
                                        <div class="w-60">
                                            <div class="block px-4 py-2 text-xs text-gray-400">
                                                {{ __('Изменить статус на') }}
                                            </div>

                                            @foreach($this->statusOptions() as $status => $label)
                                                @if ($lead->canChangeStatusTo($status))
                                                    <x-jet-dropdown-link wire:click.prevent="changeStatus('{{ $status }}')" class="cursor-pointer">
                                                        {{ $label }}
                                                    </x-jet-dropdown-link>
                                                @else
                                                    <x-jet-dropdown-link wire:click.prevent="" class="cursor-pointer opacity-50">
                                                        {{ $label }}
                                                    </x-jet-dropdown-link>
                                                @endif
                                            @endforeach
                                        </div>
                                    </x-slot>
                                </x-jet-dropdown>
                            </div>
                        </div>
                        <x-jet-input-error for="lead.status" class="mt-2" />
                    </div>

                    <!-- Note -->
                    <div class="col-span-6">
                        <x-jet-label for="note" value="{{ __('Примечание') }}" />
                        @if($lead->note)
                            <div style="white-space: pre;">{{ $lead->note }}</div>
                        @else
                            <div class="text-gray-400 text-sm">{{ __('Отсутствует') }}</div>
                        @endif
                        <button type="button" wire:click="$set('managingNote', true)" class="cursor-pointer">
                            <x-heroicon-o-pencil class="w-5 h-5" />
                        </button>
                    </div>
                </div>

            </div>
        </div>
    </form>

    <div class="bg-white shadow overflow-hidden sm:rounded-lg mt-6">
        <div class="border-t border-gray-200">
            <dl>
                @if($lead->name)
                    <div class="bg-gray-50 px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                        <dt class="text-sm font-medium text-gray-500">
                            {{ __('Имя лида') }}
                        </dt>
                        <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">
                            {{ $lead->name }}
                        </dd>
                    </div>
                @endif
                @if($lead->measurement_address)
                    <div class="bg-white px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                        <dt class="text-sm font-medium text-gray-500">
                            {{ __('Адрес замера') }}
                        </dt>
                        <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">
                            {{ $lead->measurement_address }}
                        </dd>
                    </div>
                @endif
                @if($lead->measurer_full_name)
                    <div class="bg-white px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                        <dt class="text-sm font-medium text-gray-500">
                            {{ __('Ф.И.О замерщика') }}
                        </dt>
                        <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">
                            {{ $lead->measurer_full_name }}
                        </dd>
                    </div>
                @endif
                @if($lead->measurement_date)
                <div class="bg-white px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                    <dt class="text-sm font-medium text-gray-500">
                        {{ __('Дата замера') }}
                    </dt>
                    <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">
                        {{ $lead->measurement_date }}
                    </dd>
                </div>
                @endif
                @if($lead->result)
                <div class="bg-gray-50 px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                    <dt class="text-sm font-medium text-gray-500">
                        {{ __('Результат замера') }}
                    </dt>
                    <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">
                        {{ $lead->result }}
                    </dd>
                </div>
                @endif
                @if($lead->decline_reason)
                <div class="bg-gray-50 px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                    <dt class="text-sm font-medium text-gray-500">
                        {{ __('Причина отказа') }}
                    </dt>
                    <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">
                        {{ $lead->decline_reason_label }}
                    </dd>
                </div>
                @endif
            </dl>
        </div>
    </div>


    <!-- Customer Modal -->
    <x-jet-dialog-modal wire:model="managingCustomer">
        <x-slot name="title">{{ __('Информация о покупателе') }}</x-slot>

        <x-slot name="content">
            <livewire:customers.customer-form :customer="$lead->customer" :in-modal="true" />
        </x-slot>

        <x-slot name="footer">
            <x-jet-secondary-button wire:click="$set('managingCustomer', false)" wire:loading.attr="disabled">
                {{ __('Nevermind') }}
            </x-jet-secondary-button>

            <x-jet-button class="ml-2" wire:click="$emit('saveCustomer')" wire:loading.attr="disabled">
                {{ __('Save') }}
            </x-jet-button>
        </x-slot>
    </x-jet-dialog-modal>

    <!-- Note Modal -->
    <x-jet-dialog-modal wire:model="managingNote">
        <x-slot name="title">{{ __('Редактирование примечания') }}</x-slot>

        <x-slot name="content">
            <form wire:submit="saveNote">
                <!-- Note -->
                <div class="col-span-6">
                    <x-jet-label for="note" value="{{ __('Примечание') }}" />
                    <x-textarea id="note" rows="10" class="block w-full" wire:model="lead.note"></x-textarea>
                    <x-jet-input-error for="lead.note" class="mt-2" />
                </div>
            </form>
        </x-slot>

        <x-slot name="footer">
            <x-jet-secondary-button wire:click="$set('managingNote', false)" wire:loading.attr="disabled">
                {{ __('Nevermind') }}
            </x-jet-secondary-button>

            <x-jet-button class="ml-2" wire:click="saveNote" wire:loading.attr="disabled">
                {{ __('Save') }}
            </x-jet-button>
        </x-slot>
    </x-jet-dialog-modal>

    <!-- Change Status To Not Responded -->
    <x-jet-dialog-modal wire:model="changingStatusToNotResponded">
        <x-slot name="title">{{ __('Недозвон') }}</x-slot>

        <x-slot name="content">
            <form wire:submit.prevent="saveStatusNotResponded">
                <div class="grid grid-cols-6">

                    <!-- No Respond Reason -->
                    <div class="col-span-6">
                        <x-jet-label for="no_respond_reason" value="{{ __('Причина') }}" />
                        <x-select id="no_respond_reason" class="w-full block" wire:model.defer="lead.no_respond_reason">
                            <option value=""></option>
                            @foreach($this->noRespondReasonOptions() as $value => $label)
                                <option value="{{ $value }}">{{ $label }}</option>
                            @endforeach
                        </x-select>
                        <x-jet-input-error for="lead.no_respond_reason" class="mt-2" />
                    </div>
                </div>
            </form>
        </x-slot>

        <x-slot name="footer">
            <x-jet-secondary-button wire:click="$set('changingStatusToNotResponded', false)" wire:loading.attr="disabled">
                {{ __('Nevermind') }}
            </x-jet-secondary-button>

            <x-jet-button class="ml-2" wire:click="saveStatusNotResponded" wire:loading.attr="disabled">
                {{ __('Подтвердить') }}
            </x-jet-button>
        </x-slot>
    </x-jet-dialog-modal>

    <!-- Change Status To Measurement -->
    <x-jet-dialog-modal wire:model="changingStatusToMeasurement">
        <x-slot name="title">{{ __('Договоренность о замере') }}</x-slot>

        <x-slot name="content">
            <form wire:submit.prevent="saveStatusMeasurement">
                <div class="grid grid-cols-6 gap-6">

                    <!-- Measurement address -->
                    <div class="col-span-6">
                        <x-jet-label for="measurement_address" value="{{ __('Адрес замера') }}" />
                        <x-textarea id="measurement_address" rows="2" class="block w-full" wire:model="lead.measurement_address"></x-textarea>
                        <x-jet-input-error for="lead.measurement_address" class="mt-2" />
                    </div>

                    <!-- Measurer full name -->
                    <div class="col-span-6">
                        <x-jet-label for="measurer_full_name" value="{{ __('Ф.И.О замерщика') }}" />
                        <x-jet-input type="text" id="measurer_full_name" class="block w-full" wire:model="lead.measurer_full_name" />
                        <x-jet-input-error for="lead.measurer_full_name" class="mt-2" />
                    </div>

                    <!-- Measurement date -->
                    <div class="col-span-6">
                        <x-jet-label for="measurement_date" value="{{ __('Дата замера') }}" />
                        <x-jet-input type="date" id="measurement_date" class="block w-full" wire:model="lead.measurement_date" />
                        <x-jet-input-error for="lead.measurement_date" class="mt-2" />
                    </div>
                </div>
            </form>
        </x-slot>

        <x-slot name="footer">
            <x-jet-secondary-button wire:click="$set('changingStatusToMeasurement', false)" wire:loading.attr="disabled">
                {{ __('Nevermind') }}
            </x-jet-secondary-button>

            <x-jet-button class="ml-2" wire:click="saveStatusMeasurement" wire:loading.attr="disabled">
                {{ __('Подтвердить') }}
            </x-jet-button>
        </x-slot>
    </x-jet-dialog-modal>

    <!-- Change Status To Measured -->
    <x-jet-dialog-modal wire:model="changingStatusToMeasured">
        <x-slot name="title">{{ __('Договоренность о замере') }}</x-slot>

        <x-slot name="content">
            <form wire:submit.prevent="saveStatusMeasured">
                <div class="grid grid-cols-6 gap-6">

                    <!-- Result -->
                    <div class="col-span-6">
                        <x-jet-label for="result" value="{{ __('Замер состоялся') }}" />
                        <x-textarea id="result" rows="6" class="block w-full" wire:model="lead.result"></x-textarea>
                        <x-jet-input-error for="lead.result" class="mt-2" />
                    </div>
                </div>
            </form>
        </x-slot>

        <x-slot name="footer">
            <x-jet-secondary-button wire:click="$set('changingStatusToMeasured', false)" wire:loading.attr="disabled">
                {{ __('Nevermind') }}
            </x-jet-secondary-button>

            <x-jet-button class="ml-2" wire:click="saveStatusMeasured" wire:loading.attr="disabled">
                {{ __('Подтвердить') }}
            </x-jet-button>
        </x-slot>
    </x-jet-dialog-modal>

    <!-- Change Status To Declined -->
    <x-jet-dialog-modal wire:model="changingStatusToDeclined">
        <x-slot name="title">{{ __('Не реализовано') }}</x-slot>

        <x-slot name="content">
            <form wire:submit.prevent="saveStatusDeclined">
                <div class="grid grid-cols-6 gap-6">

                    <!-- Decline Reason -->
                    <div class="col-span-6">
                        <x-jet-label for="decline_reason" value="{{ __('Причина') }}" />
                        <x-select id="decline_reason" class="w-full block" wire:model.defer="lead.decline_reason">
                            <option value=""></option>
                            @foreach($this->declineReasonOptions() as $value => $label)
                                <option value="{{ $value }}">
                                    {{ $label }}
                                </option>
                            @endforeach
                        </x-select>
                        <x-jet-input-error for="lead.decline_reason" class="mt-2" />
                    </div>
                </div>
            </form>
        </x-slot>

        <x-slot name="footer">
            <x-jet-secondary-button wire:click="$set('changingStatusToDeclined', false)" wire:loading.attr="disabled">
                {{ __('Nevermind') }}
            </x-jet-secondary-button>

            <x-jet-button class="ml-2" wire:click="saveStatusDeclined" wire:loading.attr="disabled">
                {{ __('Подтвердить') }}
            </x-jet-button>
        </x-slot>
    </x-jet-dialog-modal>
</div>

