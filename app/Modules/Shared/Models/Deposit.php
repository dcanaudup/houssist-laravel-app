<?php

namespace App\Modules\Shared\Models;

use App\Modules\Shared\Enums\DepositStatus;
use App\Modules\Shared\Enums\DepositType;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

/**
 * App\Modules\Shared\Models\Deposit
 *
 * @property int $id
 * @property int $user_id
 * @property string $deposit_type
 * @property int $amount
 * @property string $status
 * @property string $user_remarks
 * @property string $admin_remarks
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Spatie\MediaLibrary\MediaCollections\Models\Collections\MediaCollection<int, \Spatie\MediaLibrary\MediaCollections\Models\Media> $media
 * @property-read int|null $media_count
 *
 * @method static \Illuminate\Database\Eloquent\Builder|Deposit newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Deposit newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Deposit query()
 * @method static \Illuminate\Database\Eloquent\Builder|Deposit whereAdminRemarks($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Deposit whereAmount($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Deposit whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Deposit whereDepositType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Deposit whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Deposit whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Deposit whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Deposit whereUserId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Deposit whereUserRemarks($value)
 *
 * @property int $deposit_id
 * @property \Illuminate\Support\Carbon|null $latest_transaction_date
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \Spatie\Activitylog\Models\Activity> $activities
 * @property-read int|null $activities_count
 *
 * @method static \Illuminate\Database\Eloquent\Builder|Deposit whereDepositId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Deposit whereLatestTransactionDate($value)
 *
 * @mixin \Eloquent
 */
class Deposit extends Model implements HasMedia
{
    use HasFactory, InteractsWithMedia, LogsActivity;

    protected $primaryKey = 'deposit_id';

    protected $guarded = [];

    protected $casts = [
        'amount' => 'integer',
        'user_remarks' => 'string',
        'admin_remarks' => 'string',
        'latest_transaction_date' => 'datetime',
        'status' => DepositStatus::class,
        'deposit_type' => DepositType::class,
    ];

    public function amount(): Attribute
    {
        return Attribute::make(
            get: fn ($value) => is_numeric($value) ? $value / 100 : $value,
            set: fn ($value) => is_numeric($value) ? $value * 100 : $value,
        );
    }

    public function transactionDateForHumans(): Attribute
    {
        return Attribute::make(
            get: fn () => $this->created_at->format('F j, Y'),
        );
    }

    public function latestTransactionDatetimeForHumans(): Attribute
    {
        return Attribute::make(
            get: fn () => $this->latest_transaction_date->toDayDateTimeString(),
        );
    }

    protected static function booted(): void
    {
        static::saving(function (Deposit $deposit) {
            $deposit->user_remarks = $deposit->user_remarks ?? '';
            $deposit->admin_remarks = $deposit->admin_remarks ?? '';
        });
    }

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logOnly(['status', 'user_remarks', 'admin_remarks']);
    }
}
