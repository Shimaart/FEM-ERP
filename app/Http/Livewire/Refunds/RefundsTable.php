<?php

namespace App\Http\Livewire\Refunds;

use Karvaka\Wired\Table\Actions\Delete;
use Karvaka\Wired\Table\Components\Table;

class RefundsTable extends Table
{
    public function columns(): array
    {
        return [];
    }

    public function tabs(): array
    {
        return [];
    }

    public function filters(): array
    {
        return [];
    }

    public function actions(): array
    {
        return [
            new Delete
        ];
    }
}
