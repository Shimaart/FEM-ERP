<?php

namespace App\Http\Livewire\Users;

use Illuminate\Database\Eloquent\Builder;
use Karvaka\Wired\Table\Actions\Delete;
use Karvaka\Wired\Table\Actions\Restore;
use Karvaka\Wired\Table\Columns\Column;
use Karvaka\Wired\Table\Columns\Image;
use Karvaka\Wired\Table\Components\Table;
use Karvaka\Wired\Table\Filters\SelectFilter;
use Karvaka\Wired\Table\Links\Edit;
use Karvaka\Wired\Table\Tabs\Tab;
use Laravel\Jetstream\Jetstream;

class UsersTable extends Table
{
    public function columns(): array
    {
        return [
            Image::make('profile_photo_url', ''),
            Column::make('name', __('Ф.И.О'))->searchable()->sortable(),
            Column::make('email', __('Эл. адрес'))->searchable()->sortable(),
            Column::make('role.name', __('Роль'))
        ];
    }

    public function tabs(): array
    {
        return [
            Tab::make('active', __('Активные')),
            Tab::make('trashed', __('Архив'))->filterUsing(function (Builder $query) {
                $query->onlyTrashed();
            }),
        ];
    }

    public function filters(): array
    {
        return [
            SelectFilter::make('assigned_role', __('Роль'))
                ->options(collect(Jetstream::$roles)->pluck('name', 'key'))
        ];
    }

    public function links(): array
    {
        return [
            (new Edit)
                ->to(fn ($model) => route('users.edit', ['user' => $model->id]))
                ->canSee(fn ($model) => ! $model->trashed()),
        ];
    }

    public function actions(): array
    {
        return [
            Delete::make()->visible($this->tab === 'active'),
            Restore::make()->visible($this->tab === 'trashed')
        ];
    }
}
