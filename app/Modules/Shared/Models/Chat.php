<?php

namespace App\Modules\Shared\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Modules\Shared\Models\Chat
 *
 * @property int $advertisement_id
 * @property int $chat_id
 * @method static \Illuminate\Database\Eloquent\Builder|Chat newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Chat newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Chat query()
 * @method static \Illuminate\Database\Eloquent\Builder|Chat whereAdvertisementId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Chat whereChatId($value)
 * @property int $advertisement_offer_id
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Modules\Shared\Models\Message> $messages
 * @property-read int|null $messages_count
 * @method static \Illuminate\Database\Eloquent\Builder|Chat whereAdvertisementOfferId($value)
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Modules\Shared\Models\Message> $messages
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Modules\Shared\Models\Message> $messages
 * @mixin \Eloquent
 */
class Chat extends Model
{
    use HasFactory;

    protected $primaryKey = 'chat_id';

    protected $guarded = [];

    public $timestamps = false;

    public function messages()
    {
        return $this->hasMany(Message::class, 'chat_id', 'chat_id');
    }
}
