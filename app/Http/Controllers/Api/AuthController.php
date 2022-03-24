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

        $token = $user->createToken('my-auth-token')->plainTextToken;

        return response()->json([
            'token' => [
                'access_token' => $token,
                'token_type' => 'bearer',
            ],
            'user' => $user,
        ], Response::HTTP_CREATED);
    }

    public function login(LoginRequest $request)
    {
        $data = $request->only(['email', 'password']);

        $user = User::where('email', $data['email'])->first();

        if (!$user || !Hash::check($data['password'], $user->password)) {
            return response()->json(
                ['error' => 'The email or password you entered is incorrect.'
            ], Response::HTTP_UNAUTHORIZED);
        }

        $token = $user->createToken('my-auth-token')->plainTextToken;

        return response()->json([
            'token' => [
                'access_token' => $token,
                'token_type' => 'bearer',
            ],
            'user' => $user,
        ]);
    }

    public function logout()
    {
        $request->user()->currentAccessToken()->delete();

        return response()->json(['message' => 'Successfully logged out']);
    }
}
