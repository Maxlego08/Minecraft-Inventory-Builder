<?php

namespace App\Models\Conversation;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * @property int $id
 * @property String $subject
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

    public function createMessage(User $user, string $content)
    {
        ConversationMessage::create([
            'conversation_id' => $this->id,
            'user_id' => $user->id,
            'content' => $content,
        ]);

        $this->update(['last_message_at' => now()]);
        $this->createNotification($user);
    }

    public function getLastMessageURL()
    {
        $count = $this->messages->count();
        $page = (int)($count % 15 == 0 ? $count / 15 : ($count / 15) + 1);
        return route('profile.conversations.show', ['conversation' => $this, 'page' => $page]);
    }

    /**
     * Retourne le dernier message
     *
     * @return ConversationMessage
     */
    public function getLastMessage(): ConversationMessage
    {
        return $this->messages->sortByDesc('created_at')->first();
    }

    public function deleteNotification(User $user)
    {
        ConversationNotification::where('user_id', $user->id)->where('conversation_id', $this->id)->delete();
    }

    public function createNotification(User $user)
    {
        foreach ($this->participants as $participant) {
            if ($participant->user_id != $user->id) {
                ConversationNotification::firstOrCreate(
                    ['user_id' => $participant->user_id],
                    ['conversation_id' => $this->id]
                );
            }
        }
    }
}
