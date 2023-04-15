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
use Spatie\Tags\HasTags;

/**
 * @mixin IdeHelperAdvertisement
 */
class Advertisement extends Model implements HasMedia
{
    use HasFactory, InteractsWithMedia, HasTags;

    protected $primaryKey = 'advertisement_id';

    protected $fillable = [
        'user_id',
        'title',
        'description',
        'address',
        'start_date_time',
        'end_date_time',
        'payment_method',
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

    public function accepted_offer()
    {
        return $this->belongsTo(AdvertisementOffer::class, 'accepted_offer_id', 'advertisement_id');
    }
}
