<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AdvertisementOffer extends Model
{
    use HasFactory;

    protected $casts = [
        'created_at' => 'datetime',
    ];

    public function service_provider()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }
}
