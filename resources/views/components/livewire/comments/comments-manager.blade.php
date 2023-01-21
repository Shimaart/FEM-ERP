<div>
    <div class="flex justify-between items-center py-5 sm:pb-3">
        <h3 class="text-xl font-medium text-gray-900">
            {{ isset($title) ? $title : __('Комментарии') }}
        </h3>

        @can('create', \App\Models\Comment::class)
            <x-jet-button class="ml-2" wire:click="manageComment" wire:loading.attr="disabled">
                <x-heroicon-o-plus class="-ml-1 mr-2 h-4 w-4" />
                {{ __('Добавить комментарий') }}
            </x-jet-button>
        @endcan
    </div>

    {{ $table ?? '' }}

    <!-- Comment Form Modal -->
    <x-jet-dialog-modal wire:model="managingComment">
        <x-slot name="title">
            {{ __('Добавление комментария') }}
        </x-slot>

        <x-slot name="content">
            <form wire:submit="managingComment">
                <div class="grid grid-cols-6 gap-6">
                    <!-- Comment -->
                    <div class="col-span-6">
                        <x-jet-label for="comment" value="{{ __('Комментарий') }}" />
                        <x-textarea id="comment" class="mt-1 block w-full" wire:model.defer="comment.comment" rows="12" />
                        <x-jet-input-error for="comment.comment" class="mt-2" />
                    </div>
                </div>
            </form>
        </x-slot>

        <x-slot name="footer">
            <x-jet-secondary-button wire:click="$set('managingComment', false)" wire:loading.attr="disabled">
                {{ __('Nevermind') }}
            </x-jet-secondary-button>

            <x-jet-button class="ml-2" wire:click="saveComment" wire:loading.attr="disabled">
                {{ __('Save') }}
            </x-jet-button>
        </x-slot>
    </x-jet-dialog-modal>
</div>
