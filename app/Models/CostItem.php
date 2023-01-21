<?php

namespace App\Models;

use App\Concerns\HasPayments;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;

class CostItem extends Model
{
    use HasFactory, HasPayments;

    const TYPE_DEFAULT = 'default';
    const TYPE_PRODUCTION = 'production';

    protected $guarded = ['id'];

    protected $attributes = [
        'type' => self::TYPE_DEFAULT
    ];

    public static function types(): array
    {
        return array_keys(static::typeOptions());
    }

    public static function typeOptions(): array
    {
        return [
            self::TYPE_DEFAULT => __('По умолчанию'),
            self::TYPE_PRODUCTION => __('Производство')
        ];
    }
}
