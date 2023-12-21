<?php

namespace App\Http\Controllers;

use App\Models\User\NameChangeHistory;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Validation\ValidationException;

class NameChangeController extends Controller
{
    /**
     * Afficher la page pour changer de pseudo
     *
     * @return View|\Illuminate\Foundation\Application|Factory|Application
     */
    public function index(): View|\Illuminate\Foundation\Application|Factory|Application
    {
        return view('members.update_name');
    }

    /**
     * Change username
     *
     * @param Request $request
     * @return RedirectResponse
     * @throws ValidationException
     */
    public function updateName(Request $request): RedirectResponse
    {
        $this->validate($request, [
            'name' => ['required', 'string', 'max:16', 'min:3', 'regex:/^[a-zA-Z0-9_]+$/u', 'unique:users,name'],
        ]);

        $user = user();
        $oldName = $user->name;
        $newName = $request['name'];

        // Vérifier la date du dernier changement de nom
        $lastChange = $user->nameChangeHistories()->latest()->first();

        if ($lastChange && $lastChange->created_at->diffInDays(now()) < 30) {
            return Redirect::route('profile.name.index')->with('toast', createToast('error', __('profiles.change.error_time.title'), __('profiles.change.error_time.description'), 5000));
        }

        if ($oldName !== $newName) {
            $user->name = $newName;
            $user->save();

            NameChangeHistory::create([
                'user_id' => $user->id,
                'old_name' => $oldName,
                'new_name' => $newName,
            ]);

            return Redirect::route('profile.name.index')->with('toast', createToast('success', __('profiles.change.success.title'), __('profiles.change.success.description'), 5000));
        }

        return Redirect::route('profile.name.index')->with('toast', createToast('error', __('profiles.change.error.title'), __('profiles.change.error.description'), 5000));
    }

}
