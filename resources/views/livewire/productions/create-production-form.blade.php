<div>
    <form wire:submit.prevent="submit">
        <div class="shadow overflow-hidden sm:rounded-md">

            <div class="px-4 pt-5 bg-white sm:pt-6">
                <x-jet-button type="button" class="ml-2" wire:click="$set('viewProductionRequests', true)" wire:loading.attr="disabled">
                    {{ __('Необходимо произвести') }}
                </x-jet-button>

                <!-- Order Item Form Modal -->
                <x-jet-dialog-modal wire:model="viewProductionRequests">
                    <x-slot name="title">
                        {{ __('Необходимо произвести') }}
                    </x-slot>

                    <x-slot name="content">
                        <livewire:production-requests.production-requests-table />
                    </x-slot>

                    <x-slot  name="footer">
                        <x-jet-secondary-button type="button" wire:click="$set('viewProductionRequests', false)" wire:loading.attr="disabled">
                            {{ __('Close') }}
                        </x-jet-secondary-button>
                    </x-slot>
                </x-jet-dialog-modal>
            </div>

            <div class="px-4 py-5 bg-white sm:p-6">
                <div class="grid grid-cols-6 gap-6">
                    <!-- Desired Date -->
                    <div class="col-span-6 sm:col-span-2">
                        <x-jet-label for="date" value="{{ __('Дата задачи') }}" />
                        <x-jet-input type="date" id="date" class="mt-1 block w-full" wire:model.defer="production.date" />
                        <x-jet-input-error for="production.date" class="mt-2" />
                    </div>
                </div>
            </div>

            <div class="px-4 pb-5 bg-white sm:pb-4">
                <livewire:productions.production-items-manager :production="$production" />
            </div>

            <div class="flex items-center justify-end px-4 py-3 bg-gray-50 text-right sm:px-6">
                <x-jet-action-message class="mr-3" on="saved">
                    {{ __('Saved.') }}
                </x-jet-action-message>

                <x-jet-button>
                    {{ __('Save') }}
                </x-jet-button>
            </div>
        </div>
    </form>


</div>
