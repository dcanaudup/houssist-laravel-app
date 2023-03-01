<?php

namespace App\Modules\Shared\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Modules\Shared\Models\Wallet
 *
 * @property int $id
 * @property int $user_id
 * @property int $balance
 * @property string $description
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Modules\Shared\Models\User $user
 *
 * @method static \Illuminate\Database\Eloquent\Builder|Wallet newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Wallet newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Wallet query()
 * @method static \Illuminate\Database\Eloquent\Builder|Wallet whereBalance($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Wallet whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Wallet whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Wallet whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Wallet whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Wallet whereUserId($value)
 *
 * @mixin \Eloquent
 */
class Wallet extends Model
{
    use HasFactory;

    protected $fillable = [
        'description',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function balance(): Attribute
    {
        return Attribute::make(
            get: fn ($value) => number_format($value / 100, 2),
            set: fn ($value) => $value * 100,
        );
    }
}
