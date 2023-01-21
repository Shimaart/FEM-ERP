<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\Contact
 *
 * @property int $id
 * @property string $contactable_type
 * @property int $contactable_id
 * @property string $type
 * @property string $value
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|Contact newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Contact newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Contact query()
 * @method static \Illuminate\Database\Eloquent\Builder|Contact whereContactableId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Contact whereContactableType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Contact whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Contact whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Contact whereType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Contact whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Contact whereValue($value)
 * @mixin \Eloquent
 */
class Contact extends Model
{
    use HasFactory;

    const TYPE_EMAIL = 'email';
    const TYPE_PHONE_NUMBER = 'phone';

    protected $fillable = [
        'type', 'value'
    ];

    public static function types(): array
    {
        return array_keys(static::typeOptions());
    }

    public static function typeOptions(): array
    {
        return [
            self::TYPE_EMAIL => __('Эл. адрес'),
            self::TYPE_PHONE_NUMBER => __('Номер телефона')
        ];
    }
}
