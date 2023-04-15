<?php

namespace App\Modules\Shared\Models;

use App\Models\SupportTicketMessage;
use App\Modules\ServiceProvider\Models\Task;
use App\Modules\Shared\Enums\SupportTicketStatus;
use App\Modules\Shared\Enums\SupportTicketType;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Modules\Shared\Models\SupportTicket
 *
 * @property int $user_id
 * @property int $support_ticket_id
 * @property int|null $task_id
 * @property string $subject
 * @property string $reference_number
 * @property SupportTicketType $support_ticket_type
 * @property SupportTicketStatus $status
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection<int, SupportTicketMessage> $messages
 * @property-read int|null $messages_count
 * @property-read \App\Modules\Shared\Models\User $user
 * @method static \Illuminate\Database\Eloquent\Builder|SupportTicket newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|SupportTicket newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|SupportTicket query()
 * @method static \Illuminate\Database\Eloquent\Builder|SupportTicket whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SupportTicket whereReferenceNumber($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SupportTicket whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SupportTicket whereSubject($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SupportTicket whereSupportTicketId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SupportTicket whereSupportTicketType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SupportTicket whereTaskId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SupportTicket whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SupportTicket whereUserId($value)
 * @mixin \Eloquent
 * @mixin IdeHelperSupportTicket
 */
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

    public function task()
    {
        return $this->belongsTo(Task::class, 'task_id', 'task_id');
    }
    /** End Relationships */
}
