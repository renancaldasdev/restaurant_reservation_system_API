<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Http\Requests\RegisterUserRequest;
use App\Models\User;
use App\Services\UserServices;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Tymon\JWTAuth\Exceptions\JWTException;
use Tymon\JWTAuth\Facades\JWTAuth;

class JWTAuthController extends Controller
{
    public function __construct(
        private readonly UserServices $userServices
    )
    {
    }

    public function registerAdmin(RegisterUserRequest $request): JsonResponse
    {
        $data = $this->userServices->registerDataUser($request, 'admin');

        return response()->json($data, 201);
    }

    public function registerCustomer(RegisterUserRequest $request): JsonResponse
    {
        $data = $this->userServices->registerDataUser($request, 'client');

        return response()->json($data, 201);
    }


    public function login(Request $request): JsonResponse
    {
        $user = User::where('email', $request->email)->first();

        if (!$user) {
            return response()->json(['message' => 'Usuário não encontrado'], 404);
        }

        if (!Hash::check($request->password, $user->password)) {
            return response()->json(['message' => 'Senha incorreta'], 401);
        }

        $token = JWTAuth::fromUser($user);

        return response()->json(compact('token'));
    }

    public function getUser(): JsonResponse
    {
        try {
            if (!$user = JWTAuth::parseToken()->authenticate()) {
                return response()->json(['error' => 'User not found'], 404);
            }
        } catch (JWTException $e) {
            return response()->json(['error' => 'Invalid token'], 400);
        }

        return response()->json(compact('user'));
    }

    public function logout(): JsonResponse
    {
        JWTAuth::invalidate(JWTAuth::getToken());

        return response()->json(['message' => 'Successfully logged out']);
    }
}
