<?php

namespace App\Actions\Fortify;

use App\Models\Builder\Folder;
use App\Models\User;
use App\Models\UserLog;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Illuminate\Validation\ValidationException;
use Laravel\Fortify\Contracts\CreatesNewUsers;

class CreateNewUser implements CreatesNewUsers
{
    use PasswordValidationRules;

    /**
     * Validate and create a newly registered user.
     *
     * @param array $input
     * @return User
     * @throws ValidationException
     */
    public function create(array $input)
    {
        Validator::make($input, [
            'name' => ['required', 'string', 'max:16', 'min:3', 'regex:/^[a-zA-Z0-9_]+$/u', 'unique:users,name'],
            'email' => [
                'required',
                'string',
                'email',
                'max:100',
                Rule::unique(User::class),
            ],
            'terms' => ['accepted'],
            'password' => $this->passwordRules(),
        ])->validate();

        $user = User::create([
            'name' => $input['name'],
            'email' => $input['email'],
            'password' => Hash::make($input['password']),
        ]);

        UserLog::make($user, 'Création du compte', UserLog::COLOR_REGISTER, UserLog::ICON_ADD, UserLog::TYPE_CONNEXION);

        Folder::create([
            'user_id' => $user->id,
            'name' => 'home'
        ]);

        return $user;
    }
}
