<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\Transport
 *
 * @property int $id
 * @property string $name
 * @property string $kilometer_price
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|Transport newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Transport newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Transport query()
 * @method static \Illuminate\Database\Eloquent\Builder|Transport whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Transport whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Transport whereKilometerPrice($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Transport whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Transport whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class Transport extends Model
{
    use HasFactory;

    protected $guarded = [
        'id'
    ];

    protected $fillable = [
        'kilometer_price' => 'float'
    ];
}
