<?php

namespace App\Http\Controllers;

use App\Models\Alert\AlertUser;
use App\Models\User;
use App\Models\UserLog;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Redirect;

class FollowController extends Controller
{

    /**
     * Permet de suivre un joueur
     *
     * @param User $user
     * @return RedirectResponse
     */
    public function follow(User $user): RedirectResponse
    {
        if ($user->id === user()->id) return Redirect::back();

        User\Follow::firstOrCreate([
            'follower_id' => user()->id,
            'followed_id' => $user->id,
        ]);
        user()->clear('user.followings');
        $user->clear('user.followers');
        $user->clear('user.followersTable');
        $user->clear('likes.total');

        userLog("Commence à suivre $user->name.$user->id", UserLog::COLOR_SUCCESS, UserLog::ICON_USER_PLUS);
        createUniqueAlert($user->id, '', AlertUser::ICON_LIKE, AlertUser::SUCCESS, 'alerts.alerts.follow', null, user()->id);

        return Redirect::route('resources.author', ['slug' => $user->slug(), 'user' => $user->id])->with('toast', createToast('success', __('messages.follow.success.follow.title'), __('messages.follow.success.follow.description', ['name' => $user->name]), 5000));
    }

    /**
     * Permet d'arrêter de suivre un joueur
     *
     * @param User $user
     * @return RedirectResponse
     */
    public function unfollow(User $user): RedirectResponse
    {
        user()->followings()->detach($user->id);
        user()->clear('user.followings');
        $user->clear('user.followers');
        $user->clear('user.followersTable');
        $user->clear('likes.total');

        userLog("Vient d'arrêter de suivre $user->name.$user->id", UserLog::COLOR_DANGER, UserLog::ICON_USER_MINUS);

        return Redirect::route('resources.author', ['slug' => $user->slug(), 'user' => $user->id])->with('toast', createToast('success', __('messages.follow.success.unfollow.title'), __('messages.follow.success.unfollow.description', ['name' => $user->name]), 5000));
    }

}
