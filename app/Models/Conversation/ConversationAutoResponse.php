<?php

namespace App\Models\Conversation;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @property int $id
 * @property int $user_id
 * @property boolean $is_enable
 * @property string $content
 */
class ConversationAutoResponse extends Model
{
    use HasFactory;

    protected $table = "conversation_auto_responses";

    protected $fillable = ['user_id', 'content', 'is_enable'];
}
