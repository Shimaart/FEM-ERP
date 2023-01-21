<a {{ $attributes->merge(['class' => 'inline-flex items-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 active:bg-gray-900 focus:outline-none focus:border-gray-900 focus:shadow-outline-gray disabled:opacity-25 transition ease-in-out duration-150']) }}>
    <x-heroicon-o-plus class="-ml-1 mr-2 h-4 w-4" />
    {{ isset($slot) && $slot->isNotEmpty() ? $slot : __('Добавить') }}
</a>
