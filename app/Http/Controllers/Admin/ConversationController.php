<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Conversation\Conversation;
use App\Models\UserLog;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;

class ConversationController extends Controller
{
    /**
     * Afficher la liste des conversations
     *
     * @param Request $request
     * @return View|\Illuminate\Foundation\Application|Factory|Application
     */
    public function index(Request $request): View|\Illuminate\Foundation\Application|Factory|Application
    {
        $search = $request->input('search');
        $conversations = Conversation::select('conversation_conversations.*')
            ->with('user')
            ->with('messages')
            ->with('participants')
            ->distinct('conversation_conversations.id')
            ->when($search, function (Builder $query, string $search) {
                return $query
                    ->leftJoin('conversation_participants', 'conversation_conversations.id', '=', 'conversation_participants.conversation_id')
                    ->leftJoin('users', 'conversation_participants.user_id', '=', 'users.id')
                    ->where(function ($query) use ($search) {
                        $query->where('users.name', 'like', "%{$search}%")
                            ->orWhere('users.email', 'like', "%{$search}%");
                    });
            })
            ->orderBy('created_at', 'DESC')->paginate();

        return view('admins.conversations.index', [
            'conversations' => $conversations,
        ]);
    }

    /**
     * Supprime une conversation spécifiée par son identifiant.
     *
     * @param Conversation $conversation
     * @return RedirectResponse
     */
    public function delete(Conversation $conversation): RedirectResponse
    {

        // Supprime les éléments associés à la conversation
        $conversation->messages()->delete(); // Supprime tous les messages liés
        $conversation->participants()->delete(); // Supprime tous les participants liés
        $conversation->notifications()->delete(); // Supprime toutes les notifications liées

        // Supprime la conversation elle-même
        $conversation->delete();

        userLog("Suppression de la conversation $conversation->subject.$conversation->id", UserLog::COLOR_DANGER, UserLog::ICON_TRASH);

        return Redirect::route('admin.conversations.index')->with('toast',
            createToast('success', 'Succès', "Suppression de la conversation $conversation->subject.$conversation->id"));
    }
}
