<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class ResourceUserController extends Controller
{
    /**
     * Return users names
     *
     * @param Request $request
     * @return false|string
     * @throws ValidationException
     */
    public function find(Request $request): bool|string
    {
        $this->validate($request, [
            'name' => 'required'
        ]);

        $name = $request['name'];
        $users = User::select('name')->where('name', 'like', $name . '%')->limit(30)->get();
        return json_encode($users);
    }
}
