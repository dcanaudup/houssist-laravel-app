<?php

namespace App\Modules\ServiceProvider\Models;

use App\Models\User;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\AdvertisementOffer
 *
 * @property int $user_id
 * @property int $advertisement_offer_id
 * @property int $advertisement_id
 * @property float|null $payment_rate
 * @property \Illuminate\Support\Carbon|null $offer_date
 * @property float|null $counter_offer
 * @property \Illuminate\Support\Carbon|null $counter_offer_date
 * @property string $status
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\User $service_provider
 * @method static \Illuminate\Database\Eloquent\Builder|AdvertisementOffer newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|AdvertisementOffer newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|AdvertisementOffer query()
 * @method static \Illuminate\Database\Eloquent\Builder|AdvertisementOffer whereAdvertisementId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AdvertisementOffer whereAdvertisementOfferId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AdvertisementOffer whereCounterOffer($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AdvertisementOffer whereCounterOfferDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AdvertisementOffer whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AdvertisementOffer whereOfferDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AdvertisementOffer wherePaymentRate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AdvertisementOffer whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AdvertisementOffer whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AdvertisementOffer whereUserId($value)
 * @property string|null $acceptance_date
 * @method static \Illuminate\Database\Eloquent\Builder|AdvertisementOffer whereAcceptanceDate($value)
 * @mixin \Eloquent
 */
class AdvertisementOffer extends Model
{
    use HasFactory;

    protected $primaryKey = 'advertisement_offer_id';

    protected $guarded = [];

    protected $casts = [
        'payment_rate' => 'float',
        'offer_date' => 'datetime',
    ];

    public function service_provider()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    public function paymentRate(): Attribute
    {
        return Attribute::make(
            get: fn ($value) => is_numeric($value) ? $value / 100 : $value,
            set: fn ($value) => is_numeric($value) ? $value * 100 : $value,
        );
    }
}
