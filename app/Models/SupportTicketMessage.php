<?php

namespace App\Models;

use App\Vendor\InteractsWithHashedMedia;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\HasMedia;
use App\Modules\Shared\Models\User;

/**
 * App\Models\SupportTicketMessage
 *
 * @property int $support_ticket_id
 * @property int $support_ticket_message_id
 * @property int $user_id
 * @property string $message
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|SupportTicketMessage newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|SupportTicketMessage newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|SupportTicketMessage query()
 * @method static \Illuminate\Database\Eloquent\Builder|SupportTicketMessage whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SupportTicketMessage whereMessage($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SupportTicketMessage whereSupportTicketId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SupportTicketMessage whereSupportTicketMessageId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SupportTicketMessage whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SupportTicketMessage whereUserId($value)
 * @mixin \Eloquent
 * @mixin IdeHelperSupportTicketMessage
 */
class SupportTicketMessage extends Model implements HasMedia
{
    use HasFactory, InteractsWithHashedMedia;

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
