<?php

namespace App\Http\Livewire\Media;

use Livewire\Component;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

class Collection extends Component
{
    public HasMedia $model;
    public string $collection = 'default';

    protected $listeners = [
        'mediaUploaded' => '$refresh',
        'mediaDeleted' => '$refresh',
    ];

    public function download(Media $media)
    {
        return response()->download($media->getPath(),
            $media->hasCustomProperty('originalName') ?
                $media->getCustomProperty('originalName') :
                $media->getAttribute('file_name'));
    }

    public function delete(Media $media): void
    {
        $media->delete();

        $this->emit('mediaDeleted');
    }

    public function getMediaProperty(): \Illuminate\Support\Collection
    {
        return $this->model->getMedia($this->collection);
    }
}
