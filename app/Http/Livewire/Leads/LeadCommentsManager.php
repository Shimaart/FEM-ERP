<?php

namespace App\Http\Livewire\Leads;

use App\Models\Lead;
use App\Http\Livewire\Comments\ManagesComments;
use Livewire\Component;

class LeadCommentsManager extends Component
{
    use ManagesComments;

    public Lead $lead;

    protected $listeners = ['manageComment'];

    public function commentable()
    {
        return $this->lead;
    }
}
