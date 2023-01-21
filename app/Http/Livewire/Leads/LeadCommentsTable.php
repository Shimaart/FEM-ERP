<?php

namespace App\Http\Livewire\Leads;

use App\Models\Lead;
use App\Models\Comment;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Gate;
use Karvaka\Wired\Table\Actions\Action;
use Karvaka\Wired\Table\Actions\Delete;
use Karvaka\Wired\Table\Columns\Column;
use Karvaka\Wired\Table\Columns\DateTime;
use Karvaka\Wired\Table\Components\Table;

class LeadCommentsTable extends Table
{
    public Lead $lead;

    protected $listeners = [
        'leadSaved' => '$refresh',
        'commentSaved' => '$refresh'
    ];

    public bool $enablePagination = false;

    public function query(): Builder
    {
        return $this->lead->comments()->getQuery()->latest();
    }

    public function columns(): array
    {
        return [
            DateTime::make('created_at', __('Дата')),
            Column::make('author.name', __('Пользователь')),
            Column::make('comment', __('Действие')),
        ];
    }

    public function actions(): array
    {
        return [
            (new Action)
                ->component('heroicon-o-pencil')
                ->label(__('Редактировать'))
                ->canSee(fn ($model) => Gate::allows('update', $model))
                ->after(fn ($model) => $this->emit('manageComment', $model)),
            (new Delete)
                ->canSee(fn ($model) => Gate::allows('delete', $model))
                ->after(fn ($model) => $this->emit('commentDeleted', $model))
        ];
    }
}
