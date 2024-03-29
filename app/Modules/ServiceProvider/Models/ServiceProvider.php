<?php

namespace App\Modules\ServiceProvider\Models;

use App\Modules\Shared\Models\User;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Modules\ServiceProvider\Models\ServiceProvider
 *
 * @property int $id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read User|null $user
 * @method static \Illuminate\Database\Eloquent\Builder|ServiceProvider newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|ServiceProvider newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|ServiceProvider query()
 * @method static \Illuminate\Database\Eloquent\Builder|ServiceProvider whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ServiceProvider whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ServiceProvider whereUpdatedAt($value)
 * @property int $kyc_approved
 * @method static \Illuminate\Database\Eloquent\Builder|ServiceProvider whereKycApproved($value)
 * @mixin \Eloquent
 * @mixin IdeHelperServiceProvider
 */
class ServiceProvider extends Model
{
    use HasFactory;

    public function user()
    {
        return $this->morphOne(User::class, 'userable');
    }

    public function dashboardLink(): Attribute
    {
        return Attribute::make(
            get: fn ($value) => 'service-provider.dashboard',
        );
    }
}
