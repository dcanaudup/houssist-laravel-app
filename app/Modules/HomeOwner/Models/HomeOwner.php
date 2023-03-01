<?php

namespace App\Modules\HomeOwner\Models;

use App\Modules\Shared\Models\User;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Modules\HomeOwner\Models\HomeOwner
 *
 * @property int $id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read User|null $user
 *
 * @method static \Illuminate\Database\Eloquent\Builder|HomeOwner newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|HomeOwner newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|HomeOwner query()
 * @method static \Illuminate\Database\Eloquent\Builder|HomeOwner whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|HomeOwner whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|HomeOwner whereUpdatedAt($value)
 *
 * @mixin \Eloquent
 */
class HomeOwner extends Model
{
    use HasFactory;

    public function user()
    {
        return $this->morphOne(User::class, 'userable');
    }

    public function dashboardLink(): Attribute
    {
        return Attribute::make(
            get: fn ($value) => 'home-owner.dashboard',
        );
    }
}
