@if($this->media->isNotEmpty())
    <div class="px-4 py-3 bg-white shadow sm:px-6 sm:rounded-md">
        @foreach($this->media as $media)
            <div class="flex items-center justify-between py-2">
                <div class="flex items-center">
                        <div class="flex-shrink-0 h-10 w-10">
                            <a href="{{ $media->getFullUrl() }}" target="_blank">
                                @if(\Illuminate\Support\Str::startsWith($media->mime_type, 'image/'))
                                    <img class="h-10 w-10 rounded-full" src="{{ $media->getFullUrl() }}" alt="">
                                @else
                                    <x-heroicon-o-document class="w-10 h-10 text-gray-400" />
                                @endif
                            </a>
                        </div>
                    <div class="ml-4">
                        <div class="text-sm font-medium text-gray-900">
                            <a href="{{ $media->getFullUrl() }}" target="_blank">
                                @if($media->hasCustomProperty('originalName'))
                                    {{ $media->getCustomProperty('originalName') }}
                                @else
                                    {{ $media->file_name }}
                                @endif
                            </a>
                        </div>
                        <div class="text-sm text-gray-500">
                            {{ $media->mime_type }}
                        </div>
                    </div>
                </div>
                <div class="flex items-center justify-end space-x-3">
                    <a href="{{ $media->getFullUrl() }}" target="_blank" class="text-gray-400 hover:text-gray-500">
                        <x-heroicon-o-eye class="w-5 h-5" />
                    </a>
                    <a wire:click="download({{ $media->id }})" class="text-gray-400 hover:text-gray-500 cursor-pointer">
                        <x-heroicon-o-download class="w-5 h-5" />
                    </a>
                    <a wire:click="delete({{ $media->id }})" class="text-red-500 hover:text-red-600 cursor-pointer">
                        <x-heroicon-o-trash class="w-5 h-5" />
                    </a>
                </div>
            </div>
        @endforeach
    </div>
@else
    <div></div>
@endif
