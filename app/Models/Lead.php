<?php

namespace App\Models;

use App\Concerns\HasComments;
use App\Concerns\HasContacts;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Facades\Gate;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

/**
 * App\Models\Lead
 *
 * @property int $id
 * @property int|null $manager_id
 * @property int|null $customer_id
 * @property int|null $order_id
 * @property string $name
 * @property string $status
 * @property string|null $referrer
 * @property string|null $measurer_full_name
 * @property string|null $measurement_address
 * @property string|null $measurement_date
 * @property string|null $no_respond_reason
 * @property string|null $decline_reason
 * @property string|null $note
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Comment[] $comments
 * @property-read int|null $comments_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Contact[] $contacts
 * @property-read int|null $contacts_count
 * @property-read \App\Models\Customer|null $customer
 * @property-read \App\Models\User|null $manager
 * @property-read \App\Models\Order|null $order
 * @method static Builder|Lead highlightedFor(\App\Models\User $user)
 * @method static Builder|Lead newModelQuery()
 * @method static Builder|Lead newQuery()
 * @method static Builder|Lead query()
 * @method static Builder|Lead whereCreatedAt($value)
 * @method static Builder|Lead whereCustomerId($value)
 * @method static Builder|Lead whereDeclineReason($value)
 * @method static Builder|Lead whereId($value)
 * @method static Builder|Lead whereManagerId($value)
 * @method static Builder|Lead whereMeasurementAddress($value)
 * @method static Builder|Lead whereMeasurementDate($value)
 * @method static Builder|Lead whereMeasurerFullName($value)
 * @method static Builder|Lead whereName($value)
 * @method static Builder|Lead whereNoRespondReason($value)
 * @method static Builder|Lead whereNote($value)
 * @method static Builder|Lead whereOrderId($value)
 * @method static Builder|Lead whereReferrer($value)
 * @method static Builder|Lead whereStatus($value)
 * @method static Builder|Lead whereUpdatedAt($value)
 * @mixin \Eloquent
 * @property string|null $result
 * @property-read string $status_label
 * @method static Builder|Lead whereResult($value)
 * @property-read string $decline_reason_label
 */
class Lead extends Model implements HasMedia
{
    use HasFactory, HasContacts, HasComments, InteractsWithMedia;

    const STATUS_NEW = 'new';
    const STATUS_ASSIGNED = 'assigned';
    const STATUS_NOT_RESPONDED = 'not_responded';
    const STATUS_PROCESSING = 'processing';
    const STATUS_MEASUREMENT = 'measurement';
    const STATUS_MEASURED = 'measured';
    const STATUS_PREPAY = 'prepay';
    const STATUS_ACCEPTED = 'accepted';
    const STATUS_DECLINED = 'declined';
    const STATUS_SUCCESS = 'success';

    protected $guarded = ['id'];

    public static function statuses(): array
    {
        return array_keys(static::statusOptions());
    }

    public static function statusOptions(): array
    {
        return [
            self::STATUS_NEW => __('Неразобранное'),
            self::STATUS_ASSIGNED => __('Передан на обработку'),
            self::STATUS_NOT_RESPONDED => __('Недозвон'),
            self::STATUS_PROCESSING => __('В работе'),
            self::STATUS_MEASUREMENT => __('Договоренность о замере'),
            self::STATUS_MEASURED => __('Замер состоялся'),
            self::STATUS_PREPAY => __('Предоплата'),
            self::STATUS_ACCEPTED => __('Просчет сметы'),
            self::STATUS_DECLINED => __('Не реализовано'),
            self::STATUS_SUCCESS => __('Успешно реализовано')
        ];
    }

    public static function statusLabel($status): string
    {
        return self::statusOptions()[$status] ?? '';
    }

    public function getStatusLabelAttribute(): string
    {
        return self::statusLabel($this->status);
    }

    public static function statusTransitions(): array
    {
        return [
            self::STATUS_NEW => function (Lead $lead) {
                return ! is_null($lead->manager_id) && Gate::allows('assignManager', $lead);
            },
            self::STATUS_ASSIGNED => function (Lead $lead) {
                return false;
            },
            self::STATUS_NOT_RESPONDED => function (Lead $lead) {
                return ! is_null($lead->manager_id);
            },
            self::STATUS_PROCESSING => function (Lead $lead) {
                return ! is_null($lead->manager_id);
            },
            self::STATUS_MEASUREMENT => function (Lead $lead) {
                return ! is_null($lead->manager_id);
            },
            self::STATUS_MEASURED => function (Lead $lead) {
                return ! is_null($lead->manager_id);
            },
            self::STATUS_PREPAY => function (Lead $lead) {
                return false;
            },
            self::STATUS_ACCEPTED => function (Lead $lead) {
                return ! is_null($lead->manager_id) && ! is_null($lead->result);
            },
            self::STATUS_DECLINED => function (Lead $lead) {
                return ! in_array($lead->status, [
                    Lead::STATUS_PREPAY,
                    Lead::STATUS_ACCEPTED,
                    Lead::STATUS_DECLINED,
                    Lead::STATUS_SUCCESS
                ]);
            },
            self::STATUS_SUCCESS => function (Lead $lead) {
                return ! is_null($lead->manager_id) && ! is_null($lead->result);
            }
        ];
    }

    public function canChangeStatusTo(string $status): bool
    {
        if (! $can = self::statusTransitions()[$status] ?? false) {
            return false;
        }

        return call_user_func($can, $this) ?? false;
    }

    public static function noRespondReasons(): array
    {
        return array_keys(static::noRespondReasonOptions());
    }

    public static function noRespondReasonOptions(): array
    {
        return [
            'no_answer' => __('Не взял трубку'),
            'decline' => __('Сброс'),
            'busy' => __('Занято')
        ];
    }

    public static function declineReasons(): array
    {
        return array_keys(static::declineReasonOption());
    }

    public static function declineReasonOption(): array
    {
        return [
            'mistake' => 'Случайная заявка',
            'not_interested' => 'Пропала потребность',
            'another_seller' => 'Выбрали других',
            'too_expensive' => 'Слишком дорого',
            'duplicate' => 'Дубль',
            'ignore' => 'Мороз',
            'no_respond' => 'Хронический недозвон',
            'invalid_phone' => 'Неправильный номер'
        ];
    }

    public static function declineReasonLabel($reason): string
    {
        return self::declineReasonOption()[$reason] ?? '';
    }

    public function getDeclineReasonLabelAttribute(): string
    {
        return self::declineReasonLabel($this->decline_reason);
    }

    /*
    |--------------------------------------------------------------------------
    | User notifications
    |--------------------------------------------------------------------------
    */

    public function isHighlightedFor(User $user): bool
    {
        if (in_array('assign any lead manager', $user->role->permissions)) {
            return $this->status === Lead::STATUS_NEW;
        }

        return $this->status === Lead::STATUS_ASSIGNED && $this->manager_id === $user->id;
    }

    public function scopeHighlightedFor(Builder $query, User $user): Builder
    {
        if (in_array('assign any lead manager', $user->role->permissions)) {
            return $query->where('status', '=', Lead::STATUS_NEW);
        }

        return $query
            ->where('status', '=', Lead::STATUS_ASSIGNED)
            ->where('manager_id', '=', $user->id);
    }

    /*
    |--------------------------------------------------------------------------
    | Relationships
    |--------------------------------------------------------------------------
    */

    public function customer(): BelongsTo
    {
        return $this->belongsTo(Customer::class);
    }

    public function manager(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function order(): BelongsTo
    {
        return $this->belongsTo(Order::class);
    }
}
