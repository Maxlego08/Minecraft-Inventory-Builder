<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\UserRole;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Validation\ValidationException;

class UserController extends Controller
{

    /**
     * See users
     *
     * @param Request $request
     * @return View|\Illuminate\Foundation\Application|Factory|Application
     */
    public function index(Request $request): View|\Illuminate\Foundation\Application|Factory|Application
    {

        $search = $request->input('search');
        $users = User::select('users.*')
            ->when($search, function ($query, $search) {
                return $query
                    ->where('users.name', 'like', '%' . $search . '%')
                    ->orWhere('users.email', 'like', '%' . $search . '%');
            })
            ->paginate();
        return view('admins.users.index', [
            'users' => $users,
            'search' => $search
        ]);

    }

    /**
     * @param User $user
     * @return Application|Factory|View|\Illuminate\Foundation\Application
     */
    public function show(User $user): \Illuminate\Foundation\Application|View|Factory|Application
    {
        $resources = $user->resources()->paginate(10, ['*'], 'resources');
        $logs = $user->logs()->latest()->paginate(10, ['*'], 'logs');

        $roles = UserRole::all();
        return view('admins.users.show', [
            'resources' => $resources,
            'user' => $user,
            'roles' => $roles,
            'logs' => $logs,
        ]);
    }

    /**
     * @param Request $request
     * @param User $user
     * @return RedirectResponse
     * @throws ValidationException
     */
    public function store(Request $request, User $user): RedirectResponse
    {
        $this->validate($request, [
            'name' => ['required', 'string', 'max:16', 'min:3', 'regex:/^[a-zA-Z0-9_]+$/u'],
            'email' => ['required', 'string', 'email', 'max:100', 'unique:users,email,' . $user->id],
        ]);

        $user->update($request->all());
        if ($request->has('new-password')) {
            $password = $request['new-password'];
            if (strlen($password) > 6) {
                $user->update([
                    'password' => Hash::make($password),
                ]);
            } else if (strlen($password) >= 1) {

                return Redirect::back()->withInput()->withErrors([
                    'password' => 'Le mot de passe doit avoir au minimum 6 characters.'
                ]);
            }
        }

        return Redirect::route('admin.users.show', ['user' => $user])->with('toast',
            createToast('success', 'Succès', "Modification de l'utilisateur " . $user->name));
    }

}
