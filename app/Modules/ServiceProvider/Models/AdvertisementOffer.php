<?php

namespace App\Modules\ServiceProvider\Models;

use App\Modules\HomeOwner\Enums\AdvertisementOfferStatus;
use App\Modules\Shared\Models\Advertisement;
use App\Modules\Shared\Models\User;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\AdvertisementOffer
 *
 * @mixin \Eloquent
 * @mixin IdeHelperAdvertisementOffer
 */
class AdvertisementOffer extends Model
{
    use HasFactory;

    protected $primaryKey = 'advertisement_offer_id';

    protected $guarded = [];

    protected $casts = [
        'payment_rate' => 'float',
        'offer_date' => 'datetime',
        'status' => AdvertisementOfferStatus::class,
    ];

    /** Relationships */
    public function service_provider()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    public function advertisement()
    {
        return $this->belongsTo(Advertisement::class, 'advertisement_id', 'advertisement_id');
    }
    /** End Relationships */

    /** Attributes */
    public function paymentRate(): Attribute
    {
        return Attribute::make(
            get: fn ($value) => is_numeric($value) ? $value / 100 : $value,
            set: fn ($value) => is_numeric($value) ? $value * 100 : $value,
        );
    }
    /** End Attributes */
}
