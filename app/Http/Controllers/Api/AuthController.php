<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
    /**
     * Permet de récupérer un code api
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function login(Request $request): JsonResponse
    {
        try {
            $validator = Validator::make($request->all(), [
                'email' => 'required|email',
                'password' => 'required'
            ]);

            if ($validator->failed()) {
                return response()->json([
                    'status' => false,
                    'message' => 'Validation error',
                    'error' => $validator->errors()->first()
                ]);
            }

            if (!Auth::attempt($request->only(['email', 'password']))) {
                return response()->json([
                    'status' => false,
                    'message' => 'Email & Password does not match with our record'
                ]);
            }

            $user = User::where('email', $request['email'])->first();
            $tokens = $user->tokens()->where('name', env('TOKEN_NAME'))->get();
            foreach ($tokens as $token) {
                $token->delete();
            }

            return response()->json([
                'status' => true,
                'message' => 'User login successfully',
                'token' => $user->createToken(env('TOKEN_NAME'), [env('ABILITY_RESOURCE')])->plainTextToken,
            ]);

        } catch (\Throwable $exception) {
            return response()->json([
                'status' => false,
                'message' => $exception->getMessage()
            ]);
        }
    }
}
