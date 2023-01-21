<?php

namespace App\Events;

use App\Models\Lead;
use Illuminate\Foundation\Events\Dispatchable;

final class LeadCreated
{
    use Dispatchable;

    const SOURCE_API = 'api';
    const SOURCE_FORM = 'form';

    public Lead $lead;

    public string $source = self::SOURCE_FORM;

    public function __construct(Lead $lead, string $source = self::SOURCE_FORM)
    {
        $this->lead = $lead;
        $this->source = $source;
    }
}
