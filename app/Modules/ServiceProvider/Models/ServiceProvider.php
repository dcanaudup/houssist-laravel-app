<?php

namespace App\Modules\ServiceProvider\Models;

use App\Modules\Shared\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ServiceProvider extends Model
{
    use HasFactory;

    public function user()
    {
        return $this->morphOne(User::class, 'userable');
    }
}
