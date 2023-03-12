<?php

namespace App\Modules\Shared\Models;

use App\Modules\HomeOwner\Enums\JobPaymentType;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

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
    ];

    public function paymentRate(): Attribute
    {
        return Attribute::make(
            get: fn ($value) => is_numeric($value) ? $value / 100 : $value,
            set: fn ($value) => is_numeric($value) ? $value * 100 : $value,
        );
    }
}
