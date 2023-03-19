<?php

namespace App\Modules\Shared\Models;

use App\Modules\HomeOwner\Enums\AdvertisementStatus;
use App\Modules\HomeOwner\Enums\JobPaymentType;
use App\Modules\ServiceProvider\Models\AdvertisementOffer;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

/**
 * App\Modules\Shared\Models\Advertisement
 *
 * @property int $user_id
 * @property int $advertisement_id
 * @property string $title
 * @property string $description
 * @property string $address
 * @property \Illuminate\Support\Carbon $start_date_time
 * @property \Illuminate\Support\Carbon $end_date_time
 * @property JobPaymentType $job_payment_type
 * @property int $payment_rate
 * @property AdvertisementStatus $status
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Modules\Shared\Models\User $home_owner
 * @property-read \Spatie\MediaLibrary\MediaCollections\Models\Collections\MediaCollection<int, Media> $media
 * @property-read int|null $media_count
 *
 * @method static \Illuminate\Database\Eloquent\Builder|Advertisement newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Advertisement newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Advertisement query()
 * @method static \Illuminate\Database\Eloquent\Builder|Advertisement whereAddress($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Advertisement whereAdvertisementId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Advertisement whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Advertisement whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Advertisement whereEndDateTime($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Advertisement whereJobPaymentType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Advertisement wherePaymentRate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Advertisement whereStartDateTime($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Advertisement whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Advertisement whereTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Advertisement whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Advertisement whereUserId($value)
 *
 * @property int $accepted_offer_id
 *
 * @method static \Illuminate\Database\Eloquent\Builder|Advertisement whereAcceptedOfferId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Advertisement whereServiceProviderId($value)
 *
 * @property-read \Spatie\MediaLibrary\MediaCollections\Models\Collections\MediaCollection<int, Media> $media
 * @property-read \Illuminate\Database\Eloquent\Collection<int, AdvertisementOffer> $offers
 * @property-read int|null $offers_count
 *
 * @mixin \Eloquent
 */
class Advertisement extends Model implements HasMedia
{
    use HasFactory, InteractsWithMedia;

    protected $primaryKey = 'advertisement_id';

    protected $fillable = [
        'user_id',
        'title',
        'description',
        'address',
        'start_date_time',
        'end_date_time',
        'job_payment_type',
        'payment_rate',
        'status',
    ];

    protected $casts = [
        'start_date_time' => 'datetime',
        'end_date_time' => 'datetime',
        'job_payment_type' => JobPaymentType::class,
        'status' => AdvertisementStatus::class,
    ];

    public function paymentRate(): Attribute
    {
        return Attribute::make(
            get: fn ($value) => is_numeric($value) ? $value / 100 : $value,
            set: fn ($value) => is_numeric($value) ? $value * 100 : $value,
        );
    }

    public function registerMediaConversions(Media $media = null): void
    {
        $this->addMediaConversion('thumb')
            ->performOnCollections('advertisement-featured', 'advertisement-attachments')
            ->width(264)
            ->height(301);
    }

    public function home_owner()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    public function offers()
    {
        return $this->hasMany(AdvertisementOffer::class, 'advertisement_id', 'advertisement_id');
    }
}
