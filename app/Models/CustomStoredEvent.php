<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Spatie\EventSourcing\StoredEvents\Models\EloquentStoredEvent;

class CustomStoredEvent extends EloquentStoredEvent
{
    use HasFactory;

    public static function boot()
    {
        parent::boot();

        static::creating(function (CustomStoredEvent $storedEvent) {
            $storedEvent->meta_data['user_id'] = auth()->id();
        });
    }
}
