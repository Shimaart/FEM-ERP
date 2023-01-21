<form method="POST" wire:submit.prevent="upload">
    <div class="flex items-center justify-content-between space-x-1"
         x-data="{ isUploading: false, progress: 0 }"
         x-on:livewire-upload-start="isUploading = true"
         x-on:livewire-upload-finish="isUploading = false"
         x-on:livewire-upload-error="isUploading = false"
         x-on:livewire-upload-progress="progress = $event.detail.progress"
    >
        <input type="file" wire:model="file" class="form-input shadow">
        <x-heroicon-o-refresh wire:loading wire:target="file" class="h-5 w-5 text-gray-400 animate-spin" />
        <div x-show="isUploading" class="text-gray-400">
            <span x-text="progress"></span>%
        </div>
    </div>

    <x-jet-input-error for="file" class="mt-2" />
</form>
