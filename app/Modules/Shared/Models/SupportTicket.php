<?php

namespace App\Modules\Shared\Models;

use App\Models\SupportTicketMessage;
use App\Modules\Shared\Enums\SupportTicketStatus;
use App\Modules\Shared\Enums\SupportTicketType;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SupportTicket extends Model
{
    use HasFactory;

    protected $primaryKey = 'support_ticket_id';

    protected $casts = [
        'support_ticket_type' => SupportTicketType::class,
        'status' => SupportTicketStatus::class,
    ];

    protected $fillable = [
        'user_id',
        'task_id',
        'subject',
        'reference_number',
        'support_ticket_type',
        'status',
    ];

    /** Relationships */
    public function messages()
    {
        return $this->hasMany(SupportTicketMessage::class, 'support_ticket_id', 'support_ticket_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }
    /** End Relationships */
}
