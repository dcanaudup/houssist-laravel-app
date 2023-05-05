<?php

namespace App\Modules\Shared\Models;

use App\Modules\ServiceProvider\Models\AdvertisementOffer;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;

/**
 * App\Modules\Shared\Models\Chat
 *
 * @mixin \Eloquent
 * @mixin IdeHelperChat
 */
class Chat extends Model
{
    use HasFactory;

    const CACHE_KEY = 'chat_';

    protected $primaryKey = 'chat_id';

    protected $guarded = [];

    public $timestamps = false;

    protected static function booted()
    {
        static::updated(function ($model) {
            Cache::forget(self::CACHE_KEY.$model->advertisement_offer_id);
        });
    }

    public function messages()
    {
        return $this->hasMany(Message::class, 'chat_id', 'chat_id');
    }

    public function advertisement_offer()
    {
        return $this->belongsTo(AdvertisementOffer::class, 'advertisement_offer_id', 'advertisement_offer_id');
    }
}
