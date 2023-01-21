<?php

namespace App\Concerns;

use App\Models\Contact;
use App\Models\Payment;
use Illuminate\Database\Eloquent\Relations\MorphMany;

trait HasPayments
{
    public function payments(): MorphMany
    {
        return $this->morphMany(Payment::class, 'paymentable'); // TODO paymentable => payable
    }

    public function getPaidSum(): float
    {
        return (float)$this->payments()->sum('amount');
    }
}
