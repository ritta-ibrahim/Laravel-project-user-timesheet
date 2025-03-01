<?php

namespace App\Http\Controllers\Auth;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Http\Requests\LoginRequest;
use App\Http\Controllers\Controller;
use App\Http\Resources\UserResource;
use App\Http\Requests\RegisterRequest;

class AuthController extends Controller
{
    public function register(RegisterRequest $request)
    {
        $data = $request->validated();
        $user = User::create($data);

        return Response::api(new UserResource($user));
    }

    public function login(LoginRequest $request)
    {
        $data = $request->safe()->only(['email', 'password']);
        $user = User::where('email', $data['email'])->first();

        if ($user) {
            $credentials = ['email' => $user->email, 'password' => $request->password];
            if (auth()->attempt($credentials)) {
                $token = auth()->user()->createToken('AUTH');
                return Response::api([
                    'success' => true,
                    'token' => $token->accessToken,
                    'user' => [
                        'id' => auth()->user()->id,
                        'email' => auth()->user()->email,
                        'token' => $token->accessToken,
                        'token_expires_at' => $token->token->expires_at,
                    ],
                ]);
            } else {
                return Response::api([
                    'success' => false,
                    'error' => __('auth.failed'),
                ], Response::HTTP_UNAUTHORIZED);
            }
        } else {
            return Response::api([
                'success' => false,
                'error' => __('auth.not_found'),
            ], Response::HTTP_NOT_FOUND);
        }
    }

    public function logout(Request $request)
    {
        $request->user()->tokens()->where('revoked', false)->update(['revoked' => true]);

        return Response::api([
            'success' => true,
            'message' => __('Logged out successfully.'),
        ]);
    }
}
