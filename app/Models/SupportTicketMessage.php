<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SupportTicketMessage extends Model
{
    use HasFactory;

    protected $primaryKey = 'support_ticket_message_id';

    protected $fillable = [
        'support_ticket_id',
        'user_id',
        'message',
    ];

    /** Relationships */
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }
    /** End Relationships */
}
