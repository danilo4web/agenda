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

    /**
     * @OA\Post(
     *     path="/api/auth/login",
     *     summary="Realizar login",
     *     tags={"Auth"},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"email", "password"},
     *             @OA\Property(property="email", type="string", format="email"),
     *             @OA\Property(property="password", type="string"),
     *         ),
     *     ),
     *     @OA\Response(
     *         response="200",
     *         description="Usuário logado com sucesso",
     *         @OA\JsonContent(
     *             @OA\Property(property="status", type="boolean", example=true),
     *             @OA\Property(property="message", type="string", example="Usuario logado com sucesso!"),
     *             @OA\Property(property="token", type="string"),
     *         ),
     *     ),
     *     @OA\Response(
     *         response="401",
     *         description="Email e/ou Password não foram encontrados",
     *         @OA\JsonContent(
     *             @OA\Property(property="status", type="boolean", example=false),
     *             @OA\Property(property="message", type="string"),
     *         ),
     *     ),
     *     @OA\Response(
     *         response="500",
     *         description="Erro interno do servidor",
     *         @OA\JsonContent(
     *             @OA\Property(property="status", type="boolean", example=false),
     *             @OA\Property(property="message", type="string"),
     *         ),
     *     ),
     * )
     */
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

    /**
     * @OA\Post(
     *     path="/api/auth/logout",
     *     summary="Realizar logout",
     *     tags={"Auth"},
     *     @OA\Response(
     *         response="204",
     *         description="Tokens revogados",
     *     ),
     *     @OA\Response(
     *         response="500",
     *         description="Erro interno do servidor",
     *         @OA\JsonContent(
     *             @OA\Property(property="status", type="boolean", example=false),
     *             @OA\Property(property="message", type="string"),
     *         ),
     *     ),
     * )
     */
    public function logout(): JsonResponse
    {
        auth()->user()->tokens()->delete();

        return response()->json(['message' => 'Tokens revogados'], 204);
    }
}
