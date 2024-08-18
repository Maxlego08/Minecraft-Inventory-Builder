<?php

namespace App\Models\Conversation;

use App\Code\BBCodeUtils;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * @property String $content
 * @property User $user
 * @method static ConversationMessage create(array $values)
 */
class ConversationMessage extends Model
{
    use HasFactory;

    protected $table = "conversation_messages";

    protected $fillable = ['id', 'conversation_id', 'user_id', 'content', 'created_at', 'is_automatic'];

    /**
     * @return BelongsTo
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * @return BelongsTo
     */
    public function conversation(): BelongsTo
    {
        return $this->belongsTo(Conversation::class);
    }

    /**
     * Permet de rendre le contenu
     *
     * @return string
     */
    public function toHTML(): string
    {
        return BBCodeUtils::renderAndPurify($this->content);
    }
}
