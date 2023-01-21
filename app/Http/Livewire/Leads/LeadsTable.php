<?php

namespace App\Http\Livewire\Leads;

use App\Utils;
use App\Models\Lead;
use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Karvaka\Wired\Table\Actions\Delete;
use Karvaka\Wired\Table\Columns\Column;
use Karvaka\Wired\Table\Columns\DateTime;
use Karvaka\Wired\Table\Columns\Enum;
use Karvaka\Wired\Table\Components\Table;
use Karvaka\Wired\Table\Filters\SelectFilter;
use Karvaka\Wired\Table\Links\Show;

class LeadsTable extends Table
{
    public string $defaultSort = '-created_at';

    public bool $enablePagination = false;

    public function columns(): array
    {
        return [
            Column::make('id')->sortable(),
            Column::make('manager.name', __('Менеджер'))->searchable(),
            Column::make('customer.name', __('Контрагент'))->searchable(),
            Column::make('order_id')->sortable()->searchable(),
            Enum::make('status')->sortable()->values(Lead::statusOptions()),
            DateTime::make('created_at')->sortable()
        ];
    }

    public function rowStyle(Model $model): string
    {
        return $model->isHighlightedFor(Auth::user()) ? 'danger' : 'default';
    }

    public function tabs(): array
    {
        return [];
    }

    public function filters(): array
    {
        return [
            SelectFilter::make('status')->options(Lead::statusOptions()),
            SelectFilter::make('manager_id')->options(
                User::all()
                    ->whereIn('assigned_role', array_keys(Utils::findRolesByPermissions('manage any leads')))
                    ->pluck('name', 'id')
            ),
        ];
    }

    public function links(): array
    {
        return [
            (new Show)->to(fn ($model) => route('leads.show', ['lead' => $model->id]))
        ];
    }

    public function actions(): array
    {
        return [
            new Delete
        ];
    }
}
