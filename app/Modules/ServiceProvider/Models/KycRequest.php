<?php

namespace App\Modules\ServiceProvider\Models;

use App\Modules\ServiceProvider\Enums\KycStatus;
use App\Modules\Shared\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

/**
 * App\Modules\ServiceProvider\Models\KycRequest
 *
 * @property int $id
 * @property int $user_id
 * @property string $valid_id_number
 * @property string|null $user_remarks
 * @property string|null $admin_remarks
 * @property KycStatus $status
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \Spatie\Activitylog\Models\Activity> $activities
 * @property-read int|null $activities_count
 * @property-read \Spatie\MediaLibrary\MediaCollections\Models\Collections\MediaCollection<int, \Spatie\MediaLibrary\MediaCollections\Models\Media> $media
 * @property-read int|null $media_count
 * @property-read User $user
 *
 * @method static \Illuminate\Database\Eloquent\Builder|KycRequest newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|KycRequest newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|KycRequest query()
 * @method static \Illuminate\Database\Eloquent\Builder|KycRequest whereAdminRemarks($value)
 * @method static \Illuminate\Database\Eloquent\Builder|KycRequest whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|KycRequest whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|KycRequest whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|KycRequest whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|KycRequest whereUserId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|KycRequest whereUserRemarks($value)
 * @method static \Illuminate\Database\Eloquent\Builder|KycRequest whereValidIdNumber($value)
 *
 * @mixin \Eloquent
 */
class KycRequest extends Model implements HasMedia
{
    use HasFactory, LogsActivity, InteractsWithMedia;

    protected $guarded = [];

    protected $casts = [
        'status' => KycStatus::class,
    ];

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logOnly(['status', 'user_remarks', 'admin_remarks']);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
