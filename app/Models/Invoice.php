<?php

namespace App\Models;

use App\Concerns\HasComments;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * App\Models\Invoice
 *
 * @property int $id
 * @property int $manager_id
 * @property int $supplier_id
 * @property string|null $total_amount
 * @property string|null $paid_amount
 * @property string|null $discount
 * @property string $status
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Comment[] $comments
 * @property-read int|null $comments_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\InvoiceItem[] $invoiceItems
 * @property-read int|null $invoice_items_count
 * @property-read \App\Models\User $manager
 * @property-read \App\Models\Supplier $supplier
 * @method static \Illuminate\Database\Eloquent\Builder|Invoice newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Invoice newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Invoice query()
 * @method static \Illuminate\Database\Eloquent\Builder|Invoice whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Invoice whereDiscount($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Invoice whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Invoice whereManagerId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Invoice wherePaidAmount($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Invoice whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Invoice whereSupplierId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Invoice whereTotalAmount($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Invoice whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class Invoice extends Model
{
    use HasFactory, HasComments;

    const STATUS_CREATED = 'created';
    const STATUS_INVOICED = 'invoiced';
    const STATUS_CANCELED = 'canceled';
    const STATUS_CLOSED = 'closed';

    protected $guarded = [
        'id'
    ];

    protected $fillable = [
        'total_amount' => 'float',
        'paid_amount' => 'float',
        'discount' => 'float',
    ];

    public static function statuses(): array
    {
        return [
            self::STATUS_CREATED,
            self::STATUS_INVOICED,
            self::STATUS_CANCELED,
            self::STATUS_CLOSED
        ];
    }

    /*
    |--------------------------------------------------------------------------
    | Relationships
    |--------------------------------------------------------------------------
    */
    public function manager(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function supplier(): BelongsTo
    {
        return $this->belongsTo(Supplier::class);
    }

    public function invoiceItems(): HasMany//может назвать products??
    {
        return $this->hasMany(InvoiceItem::class);
    }
}
