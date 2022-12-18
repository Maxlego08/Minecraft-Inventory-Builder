<?php

namespace App\Models\Conversation;

use App\Code\BBCode;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Stevebauman\Purify\Facades\Purify;

/**
 * @property String $content
 * @method static ConversationMessage create(array $values)
 */
class ConversationMessage extends Model
{
    use HasFactory;

    protected $table = "conversation_messages";

    protected $fillable = ['id', 'conversation_id', 'user_id', 'content'];

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

    public function toHTML()
    {
        $renderer = new BBCode();
        return Purify::clean($renderer->render($this->content));
        // return $renderer->render($this->content);
    }
}
