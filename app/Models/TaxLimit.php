<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class TaxLimit extends Model
{
    use HasFactory, SoftDeletes;

    const STATUS_CREATED = 'created';
    const STATUS_CLOSED = 'closed';

    protected $fillable = [
        'month',
        'value',
        'status'
    ];

    protected $casts = [
        'month' => 'date:Y-m-d'
    ];

    public static function statuses(): array
    {
        return array_keys(self::statusOptions());
    }

    public static function statusOptions(): array
    {
        return [
            self::STATUS_CREATED => __('Создан'),
            self::STATUS_CLOSED => __('Закрыт'),
        ];
    }
}
