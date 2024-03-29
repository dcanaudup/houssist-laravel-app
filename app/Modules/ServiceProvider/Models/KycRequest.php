<?php

namespace App\Modules\ServiceProvider\Models;

use App\Modules\ServiceProvider\Enums\KycStatus;
use App\Modules\Shared\Models\User;
use App\Vendor\InteractsWithHashedMedia;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\MediaLibrary\HasMedia;

/**
 * App\Modules\ServiceProvider\Models\KycRequest
 * @mixin \Eloquent
 * @mixin IdeHelperKycRequest
 */
class KycRequest extends Model implements HasMedia
{
    use HasFactory, LogsActivity, InteractsWithHashedMedia;

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
