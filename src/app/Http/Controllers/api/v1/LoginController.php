<?php

namespace App\Http\Controllers\api\v1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    /**
     * @param Request $request
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\Routing\ResponseFactory|\Illuminate\Http\Response
     */
    public function login(Request $request)
    {
        $login = $request->validate([
            'email' => 'required|string',
            'password' => 'required|string',
        ]);

        if (!Auth::attempt($login)) {
            return response()->json(['message' => 'Invalid login credentials.'], 403);
        }

        $userTokens = Auth::user()->tokens;
        foreach($userTokens as $token) {
            $token->revoke();
            $token->delete();
        }

        $scopes = ['test:get-users', 'test:test'];

        $access_token = Auth::user()->createToken('authToken', $scopes)->accessToken;

        return response([
            'name' => Auth::user()->name,
            'email' => Auth::user()->email,
            'access_token' => $access_token,
        ]);
    }
}
