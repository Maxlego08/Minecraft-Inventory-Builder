<?php

namespace App\Http\Controllers;

use App\Models\User;
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
        return Redirect::route('resources.author', ['slug' => $user->slug(), 'user' => $user->id])->with('toast', createToast('success', __('messages.follow.success.unfollow.title'), __('messages.follow.success.unfollow.description', ['name' => $user->name]), 5000));
    }

}
