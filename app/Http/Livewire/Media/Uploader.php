<?php

namespace App\Http\Livewire\Media;

use Illuminate\Http\UploadedFile;
use Livewire\Component;
use Livewire\TemporaryUploadedFile;
use Livewire\WithFileUploads;
use Spatie\MediaLibrary\HasMedia;

class Uploader extends Component
{
    use WithFileUploads;

    public HasMedia $model;
    public string $collection = 'default';

    /**
     * @var TemporaryUploadedFile|null
     */
    public $file = null;

    public function updatedFile(): void
    {
        $this->validate([
            'file' => ['required', 'file']
        ], [], [
            'file' => __('Файл')
        ]);

        $path = $this->file->store('public/' . $this->collection);

        $this->model
            ->addMedia(storage_path('app/' . $path))
            ->withCustomProperties([
                'originalName' => $this->file->getClientOriginalName()
            ])
            ->toMediaCollection($this->collection);

        $this->emit('mediaUploaded');

        $this->file = null;
    }
}
