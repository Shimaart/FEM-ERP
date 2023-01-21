<div>
    <div class="flex justify-between items-center pb-5 sm:pb-3">
        <h3 class="text-xl font-medium text-gray-900">{{ __('Расходы / Доходы') }}</h3>

        <x-jet-button class="ml-2" wire:click="managePayment" wire:loading.attr="disabled">
            <x-heroicon-o-plus class="-ml-1 mr-2 h-4 w-4" />
            {{ __('Добавить расход') }}
        </x-jet-button>
    </div>

    <livewire:payments.payments-table />

    <!-- New Payment Modal -->
    <x-jet-dialog-modal wire:model="managingPayment">
        <x-slot name="title">
            {{ __('Новый платеж') }}
        </x-slot>

        <x-slot name="content">
            <form wire:submit="savePayment">
                <div class="grid grid-cols-6 gap-6">
                    <div class="col-span-6 sm:col-span-4">
                        <x-jet-label for="paymentable_id" value="{{ __('Статья затрат') }}" />
                        <select  wire:change="paymentSelected"  class="form-input rounded-md shadow-sm block w-full" wire:model.defer="payment.paymentable_id">
                            <option value=""></option>
                            @foreach($this->costItems as $costItem)
                                <option value="{{ $costItem->id }}">{{ $costItem->name }}</option>
                            @endforeach
                        </select>
                        <x-jet-input-error for="payment.paymentable_id" class="mt-2" />
                    </div>

                    @if($hasMaterials)
                        <div class="col-span-6 sm:col-span-4">
                            <x-jet-label for="item_id" value="{{ __('Сырье') }}" />
                            <select wire:change="itemSelected" class="form-input rounded-md shadow-sm block w-full" wire:model.defer="paymentMaterial.item_id">
                                <option value=""></option>
                                @foreach($this->materials as $material)
                                    <option value="{{ $material->id }}">{{ $material->name }}</option>
                                @endforeach
                            </select>
                            <x-jet-input-error for="paymentMaterial.item_id" class="mt-2" />
                        </div>

                        <div class="col-span-6 sm:col-span-4">
                            <x-jet-label for="quantity" value="{{ __('К-во') }}" />
                            <x-jet-input id="quantity" type="number" min="0" class="mt-1 block w-full" wire:model.defer="paymentMaterial.quantity" autofocus />
                            <x-jet-input-error for="paymentMaterial.quantity" class="mt-2" />
                        </div>

                        <div class="col-span-6 sm:col-span-4">
                            <x-jet-label for="purchase_price" value="{{ __('Цена закупки') }}" />
                            <x-jet-input id="purchase_price" type="number" min="0" class="mt-1 block w-full" wire:model.defer="paymentMaterial.purchase_price" autofocus />
                            <x-jet-input-error for="paymentMaterial.purchase_price" class="mt-2" />
                        </div>
                    @endif

                    <div class="col-span-6 sm:col-span-4">
                        <x-jet-label for="amount" value="{{ __('Сумма') }}" />
                        <x-jet-input id="amount" type="number" min="0" class="mt-1 block w-full" wire:model.defer="payment.amount" autofocus />
                        <x-jet-input-error for="payment.amount" class="mt-2" />
                    </div>

                    <div class="col-span-6 sm:col-span-4">
                        <x-jet-label for="payment_type" value="{{ __('Рассчет') }}" />
                        <select class="form-input rounded-md shadow-sm block w-full" wire:model.defer="payment.payment_type">
                            @foreach(\App\Models\Payment::paymentTypeOptions() as $value => $label)
                                <option value="{{ $value }}">{{ $label }}</option>
                            @endforeach
                        </select>
                        <x-jet-input-error for="payment.payment_type" class="mt-2" />
                    </div>

                    @if($this->payment && $this->payment->status !== \App\Models\Payment::STATUS_PAID)
                        <div class="col-span-6 sm:col-span-4">
                            <x-jet-label for="status" value="{{ __('Статус') }}" />
                            <select class="form-input rounded-md shadow-sm block w-full" wire:model.defer="payment.status">
                                @foreach(\App\Models\Payment::statusOptions() as $value => $label)
                                    <option value="{{ $value }}">{{ $label }}</option>
                                @endforeach
                            </select>
                            <x-jet-input-error for="payment.status" class="mt-2" />
                        </div>
                    @endif
                </div>
            </form>
        </x-slot>

        <x-slot name="footer">
            <x-jet-secondary-button wire:click="$set('managingPayment', false)" wire:loading.attr="disabled">
                {{ __('Nevermind') }}
            </x-jet-secondary-button>

            <x-jet-button class="ml-2" wire:click="savePayment" wire:loading.attr="disabled">
                {{ __('Save') }}
            </x-jet-button>
        </x-slot>
    </x-jet-dialog-modal>
</div>
