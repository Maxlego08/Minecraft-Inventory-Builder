<?php

namespace App\Models\Conversion;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * @property String $content
 * @property ConversationMessage[] $messages
 * @property ConversationParticipant[] $participants
 * @property User $user
 *
 */
class Conversation extends Model
{
    use HasFactory;

    protected $table = "conversation_conversations";

    protected $fillable = [
        'user_id', 'subject', 'last_message_at'
    ];

    protected $dates = ['last_message_at'];

    /**
     * @return BelongsTo
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * @return HasMany
     */
    public function messages(): HasMany
    {
        return $this->hasMany(ConversationMessage::class);
    }

    /**
     * @return HasMany
     */
    public function participants(): HasMany
    {
        return $this->hasMany(ConversationParticipant::class);
    }
}
