<?php

namespace App\Http\Controllers;

use App\Models\Conversion\Conversation;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;

class ConversationController extends Controller
{
    /**
     * Afficher la liste des conversions d'un utilisateur
     *
     * @return Application|Factory|View
     */
    public function index(): View|Factory|Application
    {
        $conversations = Conversation::select('conversation_conversations.*')->join('conversation_participants', 'conversation_participants.conversation_id', '=', 'conversation_conversations.id')
            ->orderBy('last_message_at', 'DESC')->paginate();

        return view('members.conversations.conversation', [
            'conversations' => $conversations,
        ]);
    }
}
