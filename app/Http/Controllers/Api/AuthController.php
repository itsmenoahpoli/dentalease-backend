<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\GetCodeRequest;
use App\Http\Requests\Auth\LoginRequest;
use App\Services\AuthService;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Http\JsonResponse;

class AuthController extends Controller
{
    public function __construct(
        private readonly AuthService $authService
    )
    {}

    public function login(LoginRequest $request) : JsonResponse
    {
        $result = $this->authService->authenticate($request->validated());

        return response()->json($result, Response::HTTP_OK);
    }

    public function logout(Request $request) : JsonResponse
    {
        $user = $request->user();
        $user->currentAccessToken()->delete();

        return response()->json(['data' => 'Logged out successfully'], Response::HTTP_OK);
    }

    public function me(Request $request) : JsonResponse
    {
        $user = $request->user();

        return response()->json($user, Response::HTTP_OK);
    }

    public function requestCode(GetCodeRequest $request) : JsonResponse
    {
        $result = $this->authService->createCode($request->validated());

        return response()->json($result, Response::HTTP_OK);
    }
}
