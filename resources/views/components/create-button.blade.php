<x-jet-button {{ $attributes->merge(['type' => 'button']) }}>
    <x-heroicon-o-plus class="-ml-1 mr-2 h-4 w-4" />
    {{ isset($slot) && $slot->isNotEmpty() ? $slot : __('Добавить') }}
</x-jet-button>
