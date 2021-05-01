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
     *
     * @OA\Post(
     *     path="/api/v1/user/get_token",
     *     tags={"Auth"},
     *     summary="Get new access token",
     *     description="Get new access token",
     *     operationId="getToken",
     *     @OA\RequestBody(
     *      required=true,
     *      description="Pass user credentials",
     *      @OA\MediaType(
     *          mediaType="multipart/form-data",
     *          @OA\Schema(
     *              @OA\Property(property="email", type="string", format="email", example="user1@mail.com"),
     *              @OA\Property(property="password", type="password", format="password", example="1234567"),
     *          ),
     *      ),
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="New token returned",
     *         @OA\JsonContent(
     *              required={"email","password"},
     *              @OA\Property(property="name", type="string", format="text", example="User Name"),
     *              @OA\Property(property="email", type="string", format="email", example="user1@mail.com"),
     *              @OA\Property(property="access_token", type="string", format="text", example="NEW_ACESS_TOKEN"),
     *         ),
     *     ),
     *     @OA\Response(
     *         response=403,
     *         description="Invalid login credentials"
     *     )
     * )
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
     *
     * @OA\Post(
     *     path="/api/v1/user/register",
     *     tags={"Auth"},
     *     summary="Register a new user",
     *     description="Create a new user in the app",
     *     operationId="registerUser",
     *     security={{ "bearer": {} }},
     *     @OA\RequestBody(
     *      required=true,
     *      description="Fields dor the new user",
     *      @OA\MediaType(
     *          mediaType="multipart/form-data",
     *          @OA\Schema(
     *              @OA\Property(property="name", type="string", format="text", example="User Name"),
     *              @OA\Property(property="email", type="string", format="email", example="user1@mail.com"),
     *              @OA\Property(property="password", type="password", format="password", example="1234567"),
     *              @OA\Property(property="role", type="string", format="text", example="web-guest"),
     *          ),
     *      ),
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="New user registered",
     *         @OA\JsonContent(
     *              @OA\Property(property="message", type="string", format="text", example="User registered successfully"),
     *         ),
     *     ),
     *     @OA\Response(
     *         response=401,
     *         description="Unauthenticated",
     *         @OA\JsonContent(
     *              @OA\Property(property="message", type="string", format="text", example="Unauthenticated"),
     *         ),
     *     ),
     *     @OA\Response(
     *         response=400,
     *         description="Bad Request",
     *         @OA\JsonContent(
     *              @OA\Property(property="field1", type="string", format="text", example="Error description"),
     *              @OA\Property(property="field2", type="string", format="text", example="Error description"),
     *         ),
     *     )
     * )
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
