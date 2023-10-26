<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Services\UsuarioService;
use App\Http\Requests\Auth\LoginPostRequest;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function __construct(
        private UsuarioService $usuarioService,
    ) {
    }

    public function login(LoginPostRequest $request): JsonResponse
    {
        try {
            if (!Auth::attempt($request->only(['email', 'password']))) {
                return response()->json([
                    'status' => false,
                    'message' => 'Email e/ou Password não foram encontrados',
                ], 401);
            }

            $usuarioEntity = $this->usuarioService->obterPorEmail($request->email);

            return response()->json([
                'status' => true,
                'message' => 'Usuario logado com sucesso!',
                'token' => $this->usuarioService->criarToken($usuarioEntity)
            ], 200);
        } catch (\Throwable $th) {
            return response()->json(['status' => false, 'message' => $th->getMessage()], 500);
        }
    }

    public function logout(): JsonResponse
    {
        auth()->user()->tokens()->delete();

        return response()->json(['message' => 'Tokens revogados'], 204);
    }
}
