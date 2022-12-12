<?php

namespace App\Http\Controllers;

use App\Models\Conversion\Conversation;
use App\Models\User;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Validation\ValidationException;

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
            ->with('user')
            ->with('messages')
            ->orderBy('last_message_at', 'DESC')->paginate(15);

        return view('members.conversations.conversations', [
            'conversations' => $conversations,
        ]);
    }

    /**
     * Permet d'afficher la conversation
     *
     * @param Conversation $conversation
     * @return Application|Factory|RedirectResponse|View
     */
    public function show(Conversation $conversation): View|Factory|RedirectResponse|Application
    {

        if (!$this->hasAccessTo($conversation, user())) {
            return Redirect::route('profile.conversations.index')
                ->with('toast', createToast('error', __('conversations.error_access.title'), __('conversations.error_access.description')));
        }

        $conversation->load(['messages', 'messages.user']);

        return view('members.conversations.show', [
            'conversation' => $conversation,
        ]);
    }

    /**
     * @param Request $request
     * @param Conversation $conversation
     * @return RedirectResponse
     * @throws ValidationException
     */
    public function post(Request $request, Conversation $conversation): RedirectResponse
    {

        $user = user();
        if (!$this->hasAccessTo($conversation, $user)) {
            return Redirect::route('profile.conversations.index')
                ->with('toast', createToast('error', __('conversations.error_access.title'), __('conversations.error_access.description')));
        }

        $this->validate($request, [
            'description' => 'required|max:10000',
        ]);

        $conversation->createMessage($user, $request['description']);

        return Redirect::route('profile.conversations.show', $conversation)
            ->with('toast', createToast('success', __('conversations.send_success.title'), __('conversations.send_success.description')));
    }

    /**
     * Permet de vérifier si l'utilisateur à accès la conversation
     *
     * @param Conversation $conversation
     * @param User $user
     * @return bool
     */
    private function hasAccessTo(Conversation $conversation, User $user): bool
    {
        // ToDo Ajouter un système d'administrateur pouvant tout voir
        return $conversation->participants()->where('user_id', $user->id)->count() == 1;
    }
}
