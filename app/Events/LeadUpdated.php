<?php

namespace App\Events;

use App\Models\Lead;
use Illuminate\Foundation\Events\Dispatchable;

final class LeadUpdated
{
    use Dispatchable;

    public Lead $lead;

    public function __construct(Lead $lead)
    {
        $this->lead = $lead;
    }
}
