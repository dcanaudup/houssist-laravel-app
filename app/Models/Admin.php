<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Modules\Shared\Models\User;

class Admin extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function dashboardLink(): Attribute
    {
        return Attribute::make(
            get: fn ($value) => 'admin.dashboard',
        );
    }

    public function user()
    {
        return $this->morphOne(User::class, 'userable');
    }
}
