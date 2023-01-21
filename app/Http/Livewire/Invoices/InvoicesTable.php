<?php

namespace App\Http\Livewire\Invoices;

use Karvaka\Wired\Table\Columns\Column;
use Karvaka\Wired\Table\Components\Table;

class InvoicesTable extends Table
{
    public function columns(): array
    {
        return [
            Column::make('id')->sortable()
        ];
    }
}
