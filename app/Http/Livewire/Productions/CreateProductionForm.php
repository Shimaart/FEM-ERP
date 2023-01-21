<?php

namespace App\Http\Livewire\Productions;

use App\Models\Production;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class CreateProductionForm extends Component
{
    public Production $production;
    public bool $viewProductionRequests = false;

    public function mount(Production $production)
    {
        $this->production = $production;

        $this->production->load([
            'productionItems', 'productionItems.item',
            'comments' => function ($query) {
                return $query->latest();
            }
        ]);
    }

    public function rules ()
    {
        return [
            'production.date' => ['required', 'date:Y-m-d']
        ];
    }

    public function submit(): void
    {
        $this->validate();

        $this->production->creator_id = Auth::user()->id;
        $this->production->status = Production::STATUS_CREATED;
        $this->production->save();

        $this->production->comments()->create([
            'author_id' => Auth::user()->id,
            'comment' => 'Задача успешно создана',
            'status' => Production::STATUS_CREATED
        ]);

        $this->emit('saved');
        $this->redirect('/productions/'.$this->production->id.'/edit');
    }
}
