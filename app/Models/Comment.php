<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphTo;

/**
 * App\Models\Comment
 *
 * @property int $id
 * @property int|null $author_id
 * @property string $commentable_type
 * @property int $commentable_id
 * @property string $type
 * @property string|null $status
 * @property string|null $comment
 * @property array|null $data
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\User|null $author
 * @property-read Model|\Eloquent $commentable
 * @method static \Illuminate\Database\Eloquent\Builder|Comment newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Comment newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Comment query()
 * @method static \Illuminate\Database\Eloquent\Builder|Comment whereAuthorId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Comment whereComment($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Comment whereCommentableId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Comment whereCommentableType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Comment whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Comment whereData($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Comment whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Comment whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Comment whereType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Comment whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class Comment extends Model
{
    use HasFactory;

    const TYPE_ACTION = 'action';
    const TYPE_NOTE = 'note';

    protected $guarded = ['id'];

    protected $attributes = [
        'type' => self::TYPE_ACTION
    ];

    protected $casts = [
        'data' => 'array'
    ];

    public function author(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public static function types(): array
    {
        return array_keys(static::typeOptions());
    }

    public static function typeOptions(): array
    {
        return [
            self::TYPE_ACTION => __('Действие'),
            self::TYPE_NOTE => __('Заметка')
        ];
    }

    public function commentable(): MorphTo
    {
        return $this->morphTo();
    }
}
