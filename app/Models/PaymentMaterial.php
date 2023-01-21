<?php

namespace App\Models;

use App\Concerns\HasPayments;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class PaymentMaterial extends Model
{
    use HasFactory;

    /**
     * Get the primary key for the model.
     *
     * @return string
     */
    public function getKeyName()
    {
        return 'payment_id';
    }

    protected $guarded = [];

    public function payment(): BelongsTo
    {
        return $this->belongsTo(Payment::class);
    }

    public function item(): BelongsTo
    {
        return $this->belongsTo(Item::class);
    }
}
