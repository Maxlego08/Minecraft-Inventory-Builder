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
 * @method static Conversation create(array $values)
 */
class Conversation extends Model
{
    use HasFactory;

    protected $table = "conversation_conversations";

    protected $fillable = [
        'user_id', 'subject', 'last_message_at'
    ];

    protected $casts = [
        'last_message_at' => 'datetime'
    ];

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

    public function getLastMessageURL(): string
    {
        $count = $this->messages->count();
        $page = (int)($count % 15 == 0 ? $count / 15 : ($count / 15) + 1);
        return route('profile.conversations.show', ['conversation' => $this, 'page' => $page]) . "#last";
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

    /**
     * Permet de créer une nouvelle conversation
     *
     * @param User $user
     * @param string $subject
     * @param string $message
     * @return Conversation
     */
    public static function createNewConversation(User $user, string $subject, string $message): Conversation
    {
        $conversation = Conversation::create([
            'subject' => $subject,
            'user_id' => $user->id,
        ]);
        $conversation->addParticipant($user, false);
        $conversation->createMessage($user, $message);
        return $conversation;
    }

    /**
     * Permet d'ajouter un utilisateur à une conversation
     *
     * @param User $user
     * @param bool $notification
     * @return void
     */
    public function addParticipant(User $user, bool $notification = true): void
    {
        $exists = $this->participants()->where('user_id', $user->id)->exists();
        if (!$exists) {
            ConversationParticipant::create([
                'conversation_id' => $this->id,
                'user_id' => $user->id,
            ]);
            ConversationNotification::create([
                'user_id' => $user->id,
                'conversation_id' => $this->id
            ]);
        }
    }
}
