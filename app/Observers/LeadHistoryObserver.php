<?php

namespace App\Observers;

use App\Models\Lead;
use Illuminate\Support\Facades\Auth;

class LeadHistoryObserver
{
    public function created(Lead $lead)
    {
        $lead->comments()->create([
            'author_id' => Auth::id(),
            'comment' => __('Лид создан')
        ]);
    }

    public function updated(Lead $lead)
    {
        if ($lead->wasChanged('status')) {
            $lead->comments()->create([
                'author_id' => Auth::id(),
                'comment' => __('Изменен статус с :old на :new', [
                    'old' => Lead::statusLabel($lead->getOriginal('status')),
                    'new' => Lead::statusLabel($lead->status)
                ])
            ]);
        }
    }

    public function deleted(Lead $lead)
    {
        //
    }

    public function restored(Lead $lead)
    {
        //
    }

    public function forceDeleted(Lead $lead)
    {
        //
    }
}
