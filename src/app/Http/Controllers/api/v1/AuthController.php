<?php

namespace App\Http\Controllers\api\v1;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\MessageBag;

class AuthController extends Controller
{
    /**
     * @param Request $request
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\Routing\ResponseFactory|\Illuminate\Http\Response
     */
    public function getToken(Request $request): JsonResponse
    {
        $login = $request->validate([
            'email' => 'required|string',
            'password' => 'required|string',
        ]);

        if (!Auth::attempt($login)) {
            return response()->json(['message' => 'Invalid login credentials.'], 403);
        }

        $user = Auth::user();
        $user->removeTokens();

        $access_token = $user->createToken('authToken', $user->getScopes())->accessToken;

        return response()->json(
            [
                'name' => $user->name,
                'email' => $user->email,
                'access_token' => $access_token,
            ],
            200
        );
    }

    /**
     * Register a new user
     *
     * @param Request $request
     *
     * @return JsonResponse
     */
    public function register(Request $request): JsonResponse
    {
        $validation_rules = [
            'role' => 'required|string|in:admin,web-guest,mobile-guest',
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|unique:users',
            'password' => 'required|string|min:6',
        ];

        $validation = Validator::make($request->input(), $validation_rules);

        if ($validation->fails()) {
            return response()->json($this->getArrayErrors($validation->errors()), 400);
        }

        User::create([
            'role'     => $request->role,
            'name'     => $request->name,
            'email'    => $request->email,
            'password' => Hash::make($request->password),
        ]);

        return response()->json(['message' => 'User registered successfully'], 200);
    }

    /**
     * Return a array with the errors by field
     *
     * The errors come from a validator object. The idea is get the MessageBag
     * from the method errors in an Illuminate\Contracts\Validation\Validator object.
     *
     * @param MessageBag $message_bag
     *
     * @return array
     */
    protected function getArrayErrors(MessageBag $message_bag): array
    {
        $errors = [];

        foreach ($message_bag->getMessages() as $field => $err) {
            $errors[$field] = is_array($err) ? reset($err) : $err;
        }

        return $errors;
    }
}
