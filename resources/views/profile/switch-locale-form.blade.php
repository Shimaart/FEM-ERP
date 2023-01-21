<x-jet-action-section>
    <x-slot name="title">
        {{ __('Изменить язык') }}
    </x-slot>

    <x-slot name="description">
        {{ __('Выберите удобный для вас язык интерфейса системы.') }}
    </x-slot>

    <x-slot name="content">
        <select class="form-input rounded-md shadow-sm block w-full" wire:model="locale">
            @foreach($this->applicationLanguages() as $locale => $language)
                <option value="{{ $locale }}">{{ $language }}</option>
            @endforeach
        </select>
    </x-slot>
</x-jet-action-section>
