<?php

namespace App\Http\Controllers;

use App\Models\Conversation\Conversation;
use App\Models\Conversation\ConversationAutoResponse;
use App\Models\User;
use App\Models\UserLog;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Validation\ValidationException;

class ConversationController extends Controller
{

    private const CACHE_MESSAGE = "messages:";

    /**
     * View a list of user conversions
     *
     * @return Application|Factory|View
     */
    public function index(): View|Factory|Application
    {
        $conversations = Conversation::select('conversation_conversations.*')->join('conversation_participants', 'conversation_participants.conversation_id', '=', 'conversation_conversations.id')
            ->with('user')
            ->with('messages')
            ->where('conversation_participants.user_id', user()->id)
            ->orderBy('last_message_at', 'DESC')->paginate(15);

        return view('members.conversations.conversations', [
            'conversations' => $conversations,
        ]);
    }

    /**
     * Creates a conversation
     *
     * @param User $user
     * @return Application|Factory|View|RedirectResponse
     */
    public function create(User $user): View|Factory|RedirectResponse|Application
    {
        if ($user->id == user()->id) {
            return Redirect::route('profile.conversations.index')
                ->with('toast', createToast('error', __('conversations.error_create_self.title'), __('conversations.error_create_self.description')));
        }

        if (!$user->enable_conversation && !user()->role->isModerator()) {
            return Redirect::route('profile.conversations.index')
                ->with('toast', createToast('error', __('conversations.error_disable.title'), __('conversations.error_disable.description', ['name' => $user->name])));
        }

        return view('members.conversations.create', [
            'target' => $user,
        ]);
    }

    /**
     * @throws ValidationException
     */
    public function store(Request $request, User $user): RedirectResponse
    {

        $this->validate($request, [
            'subject' => 'required|max:255',
            'description' => 'required|max:10000',
        ]);

        $key = self::CACHE_MESSAGE . user()->id;
        if (RateLimiter::tooManyAttempts($key, 1)) {
            $seconds = RateLimiter::availableIn($key);
            return Redirect::back()->withInput()
                ->with('toast', createToast('error', __('conversations.cooldown.title'), __('conversations.cooldown.description', ['seconds' => $seconds])));
        }

        RateLimiter::hit($key, 30);

        if ($user->id == user()->id) {
            return Redirect::route('profile.conversations.index')
                ->with('toast', createToast('error', __('conversations.error_create_self.title'), __('conversations.error_create_self.description')));
        }

        if (!$user->enable_conversation && !user()->role->isModerator()) {
            return Redirect::route('profile.conversations.index')
                ->with('toast', createToast('error', __('conversations.error_disable.title'), __('conversations.error_disable.description', ['name' => $user->name])));
        }

        $conversation = Conversation::createNewConversation(user(), $request['subject'], $request['description']);
        $conversation->addParticipant($user);

        if ($user->autoResponse) {
            $conversation->createMessage($user, $user->autoResponse->content, true);
        }

        userLog("Création de la conversation avec $user->name ($conversation->id)", UserLog::COLOR_SUCCESS, UserLog::ICON_SMS);

        return Redirect::route('profile.conversations.show', ['conversation' => $conversation->id])
            ->with('toast', createToast('success', __('conversations.create_success.title'), __('conversations.create_success.description')));
    }

    /**
     * Displays the conversation
     *
     * @param Conversation $conversation
     * @return Application|Factory|RedirectResponse|View
     */
    public function show(Conversation $conversation): View|Factory|RedirectResponse|Application
    {

        $user = \user();
        if (!$this->hasAccessTo($conversation, $user)) {
            return Redirect::route('profile.conversations.index')
                ->with('toast', createToast('error', __('conversations.error_access.title'), __('conversations.error_access.description')));
        }

        // $conversation->load(['messages', 'messages.user']);
        $messages = $conversation->messages();
        $lastMessage = $messages->clone()->orderBy('created_at', 'desc')->first();
        $pagination = $messages->with('user')->paginate();

        if ($pagination->total() == 0) {
            return Redirect::route('profile.conversations.index')
                ->with('toast', createToast('error', __('conversations.error_content.title'), __('conversations.error_content.description')));
        }

        $conversation->deleteNotification($user);

        return view('members.conversations.show', [
            'conversation' => $conversation,
            'messages' => $pagination,
            'lastMessage' => $lastMessage,
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

        $key = self::CACHE_MESSAGE . user()->id;
        if (RateLimiter::tooManyAttempts($key, 1)) {
            $seconds = RateLimiter::availableIn($key);
            return Redirect::back()->withInput()
                ->with('toast', createToast('error', __('conversations.cooldown.title'), __('conversations.cooldown.description', ['seconds' => $seconds])));
        }

        RateLimiter::hit($key, 30);

        $conversation->createMessage($user, $request['description']);
        $count = $conversation->messages->count();
        $page = (int)($count % 15 == 0 ? $count / 15 : ($count / 15) + 1);

        userLog("Réponse à la conversation $conversation->id", UserLog::COLOR_SUCCESS, UserLog::ICON_SMS);

        return Redirect::route('profile.conversations.show', ['conversation' => $conversation, 'page' => $page])
            ->with('toast', createToast('success', __('conversations.send_success.title'), __('conversations.send_success.description')))
            ->withFragment("last");
    }

    /**
     * Check if the user has access to the conversation
     *
     * @param Conversation $conversation
     * @param User $user
     * @return bool
     */
    private function hasAccessTo(Conversation $conversation, User $user): bool
    {
        if ($user->role->isModerator()) return true;
        return $conversation->participants()->where('user_id', $user->id)->count() == 1;
    }

    /**
     * Permet de réponse automatiquement à un message
     *
     * @param Request $request
     * @return RedirectResponse
     * @throws ValidationException
     */
    public function autoResponse(Request $request): RedirectResponse
    {

        $this->validate($request, [
            'description' => 'required|max:2000'
        ]);

        // Mise à jour ou création de l'auto-réponse
        $autoResponse = ConversationAutoResponse::updateOrCreate(
            [
                'user_id' => user()->id
            ],
            [
                'content' => $request['description'],
                'is_enable' => $request['is_enable'] === 'on',
            ]
        );

        userLog("Mise à jour de sa réponse automatique ($autoResponse->id)", UserLog::COLOR_SUCCESS, UserLog::ICON_EDIT);

        return Redirect::route('profile.conversations.index')
            ->with('toast', createToast('success', __('conversations.auto.success.title'), __('conversations.auto.success.description')));
    }

    /**
     * Permet d'activer ou désactiver les conversations
     *
     * @param Request $request
     * @return false|string
     * @throws ValidationException
     */
    public function toggle(Request $request): bool|string
    {
        $this->validate($request, [
            'is_enable' => ['required'],
        ]);
        user()->update(['enable_conversation' => $request['is_enable'] === 'true']);
        if (user()->enable_conversation){
            userLog("Vient d'activer les messages privés", UserLog::COLOR_SUCCESS, UserLog::ICON_SMS);
        } else {
            userLog("Vient de désactiver les messages privés", UserLog::COLOR_DANGER, UserLog::ICON_SMS);
        }
        return json_encode(['message' => 'success']);
    }

}
