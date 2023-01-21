<div>
    @foreach($similarItems as $index => $similarItem)
        <div  wire:key="similar-field-{{ $index }}" class="px-4 py-5 bg-white sm:p-6">
            <div class="grid grid-cols-6 gap-6">
                <div class="col-span-6 sm:col-span-2">
                    <!-- Name -->
                    <x-jet-label for="name-{{$index}}" value="{{ __('Название') }}" />
                    <p class="pt-4">{{$similarItem->name}}</p>
                </div>
                <div class="col-span-6 {{$colspanValue}}">
                    <!-- Name -->
    {{--                    {{$similarItem->price}}--}}
                    <x-jet-label for="vendor_code-{{$index}}" value="{{ __('Артикул') }}" />
                    <x-jet-input id="vendor_code-{{$index}}" type="text" class="mt-1 block w-full" wire:model.defer="similarItems.{{ $index }}.vendor_code" />
                    <x-jet-input-error for="similarItems.{{ $index }}.vendor_code" class="mt-2" />
                </div>
                <div class="col-span-6 md:col-span-1">
                    <!-- Name -->
    {{--                    {{$similarItem->price}}--}}
                    <x-jet-label for="price-{{$index}}" value="{{ __('Цена') }}" />
                    <x-jet-input id="price-{{$index}}" type="text" class="mt-1 block w-full" wire:model.defer="similarItems.{{ $index }}.price" />
                    <x-jet-input-error for="similarItems.{{ $index }}.price" class="mt-2" />
                </div>
                <div class="col-span-6 md:col-span-1">
                    <!-- Name -->
    {{--                    {{$similarItem->price}}--}}
                    <x-jet-label for="quantity-{{$index}}" value="{{ __('Количество') }}" />
                    <x-jet-input id="quantity-{{$index}}" type="text" class="mt-1 block w-full" wire:model.defer="similarItems.{{ $index }}.quantity" />
                    <x-jet-input-error for="similarItems.{{ $index }}.quantity" class="mt-2" />
                </div>

                @if( $similarItems[$index]->category_id === 1)
                    <div class="col-span-6 md:col-span-1">
                        <!-- Name -->
                        <x-jet-label for="cost_price-{{ $index }}" value="{{ __('Себестоимость') }}" />
                        <x-jet-input id="cost_price-{{ $index }}" type="text" class="mt-1 block w-full" wire:model.defer="similarItems.{{ $index }}.cost_price" />
                        <x-jet-input-error for="similarItems.{{ $index }}.cost_price" class="mt-2" />
                    </div>
                @endif
                @if( $similarItems[$index]->category_id === 3)
                    <div class="col-span-6 md:col-span-1">
                        <!-- Name -->
                        <x-jet-label for="purchase_price-{{ $index }}" value="{{ __('Стоимость закупки') }}" />
                        <x-jet-input id="purchase_price-{{ $index }}" type="text" class="mt-1 block w-full" wire:model.defer="similarItems.{{ $index }}.purchase_price" />
                        <x-jet-input-error for="similarItems.{{ $index }}.purchase_price" class="mt-2" />
                    </div>
                @endif
            </div>

        </div>
    @endforeach
</div>
