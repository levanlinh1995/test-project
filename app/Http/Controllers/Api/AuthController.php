<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Http\Requests\Auth\RegisterRequest;
use App\Http\Requests\Auth\LoginRequest;
use Illuminate\Support\Facades\Hash;
use App\Repositories\User\UserRepository;
use App\Repositories\User\UserRepositoryInterface;
use App\Models\User;

class AuthController extends Controller
{
    protected UserRepository $userRepository;

    public function __construct(UserRepositoryInterface $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    public function register(RegisterRequest $request)
    {
        $data = $request->only(['email', 'password']);

        $user = $this->userRepository->create([
            'email' => $data['email'],
            'password' => bcrypt($data['password']),
        ]);

        return response()->json([
            'message' => 'Registered successfully.',
            'user' => $user
        ], Response::HTTP_CREATED);
    }

    public function login(LoginRequest $request)
    {
        $credentials = request(['email', 'password']);

        if (! $token = auth()->attempt($credentials)) {
            return response()->json(['error' => 'Unauthorized'], Response::HTTP_UNAUTHORIZED);
        }

        return response()->json([
            'token' => [
                'access_token' => $token,
                'token_type' => 'bearer',
                'expires_in' => auth()->factory()->getTTL() * 60
            ],
            'user' => auth()->user(),
        ]);
    }
}
