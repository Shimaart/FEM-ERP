<x-jet-form-section submit="save">
    <x-slot name="title">
        {{ __('Profile Information') }}
    </x-slot>

    <x-slot name="description">
        {{ __('Редактирование данных пользователя.') }}
    </x-slot>

    <x-slot name="form">
        <!-- Name -->
        <div class="col-span-6 sm:col-span-4">
            <x-jet-label for="name" value="{{ __('Name') }}" />
            <x-jet-input id="name" type="text" class="mt-1 block w-full" wire:model.defer="user.name" autocomplete="name" />
            <x-jet-input-error for="user.name" class="mt-2" />
        </div>

        <!-- Email -->
        <div class="col-span-6 sm:col-span-4">
            <x-jet-label for="email" value="{{ __('Email') }}" />
            <x-jet-input id="email" type="email" class="mt-1 block w-full" wire:model.defer="user.email" />
            <x-jet-input-error for="user.email" class="mt-2" />
        </div>

        <!-- Role -->
        <div class="col-span-6 sm:col-span-3">
            <x-jet-label for="assigned_role" value="{{ __('Role') }}" />
            <x-select class="block w-full" wire:model="user.assigned_role">
                <option>{{ __('Не присвоена') }}</option>
                @foreach($this->roles as $role)
                    <option value="{{ $role->key }}">{{ $role->name }}</option>
                @endforeach
            </x-select>
            <x-jet-input-error for="user.assigned_role" class="mt-2" />
        </div>

        <!-- Permissions-->
        <div class="col-span-6 sm:col-span-3">
            <x-jet-label for="assigned_role" value="{{ __('Полномочия') }}" />
            @if(!count($user->role->permissions))
                <div class="text-sm text-gray-500">{{ __('Нет полномочий') }}</div>
            @elseif(in_array('*', $user->role->permissions))
                <div class="text-sm text-gray-500">{{ __('Все полномочия') }}</div>
            @else
                <ul class="list-disc list-inside">
                    @foreach($user->role->permissions as $permission)
                        <li class="text-sm text-gray-500">{{ trans('permissions.' . $permission)  }}</li>
                    @endforeach
                </ul>
            @endif
        </div>
    </x-slot>

    <x-slot name="actions">
        <x-jet-action-message class="mr-3" on="saved">
            {{ __('Saved.') }}
        </x-jet-action-message>

        <x-jet-button>
            {{ __('Save') }}
        </x-jet-button>
    </x-slot>
</x-jet-form-section>
