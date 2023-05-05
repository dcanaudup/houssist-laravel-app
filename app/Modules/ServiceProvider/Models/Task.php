<?php

namespace App\Modules\ServiceProvider\Models;

use App\Modules\ServiceProvider\Enums\TaskStatus;
use App\Modules\Shared\Models\Advertisement;
use App\Modules\Shared\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;

/**
 * App\Modules\ServiceProvider\Models\Task
 *
 * @property int $service_provider_id
 * @property int $task_id
 * @property int $home_owner_id
 * @property int $advertisement_id
 * @property int $advertisement_offer_id
 * @property string $status
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|Task newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Task newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Task query()
 * @method static \Illuminate\Database\Eloquent\Builder|Task whereAdvertisementId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Task whereAdvertisementOfferId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Task whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Task whereHomeOwnerId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Task whereServiceProviderId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Task whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Task whereTaskId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Task whereUpdatedAt($value)
 * @property-read Advertisement $advertisement
 * @property-read \App\Modules\ServiceProvider\Models\AdvertisementOffer $advertisement_offer
 * @property-read User $home_owner
 * @property-read User $service_provider
 * @mixin \Eloquent
 * @mixin IdeHelperTask
 */
class Task extends Model
{
    public const CACHE_KEY = 'task.';

    use HasFactory;

    protected $primaryKey = 'task_id';

    protected $casts = [
        'status' => TaskStatus::class,
        'reviewed_at' => 'datetime',
    ];
    protected static function booted()
    {
        static::updated(function ($model) {
            Cache::forget(self::CACHE_KEY.$model->task_id);
        });
    }

    /** Relationships */
    public function advertisement()
    {
        return $this->belongsTo(Advertisement::class, 'advertisement_id', 'advertisement_id');
    }

    public function advertisement_offer()
    {
        return $this->belongsTo(AdvertisementOffer::class, 'advertisement_offer_id', 'advertisement_offer_id');
    }

    public function home_owner()
    {
        return $this->belongsTo(User::class, 'home_owner_id', 'id');
    }

    public function service_provider()
    {
        return $this->belongsTo(User::class, 'service_provider_id', 'id');
    }
    /** End Relationships */
}
