<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\Usuario\CadastrarPostRequest;
use App\Services\UsuarioService;
use Illuminate\Http\JsonResponse;

class UsuarioController extends Controller
{
    public function __construct(
        private UsuarioService $usuarioService,
    ) {
    }

    /**
     * @OA\Post(
     *     path="/api/usuarios/cadastrar",
     *     summary="Cadastrar um novo usuário",
     *     tags={"Usuarios"},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"nome", "email", "password"},
     *             @OA\Property(property="nome", type="string"),
     *             @OA\Property(property="email", type="string", format="email"),
     *             @OA\Property(property="password", type="string"),
     *         ),
     *     ),
     *     @OA\Response(
     *         response="201",
     *         description="Usuário criado com sucesso",
     *         @OA\JsonContent(
     *             @OA\Property(property="status", type="integer", example=201),
     *             @OA\Property(property="message", type="string", example="Usuário criado com sucesso"),
     *             @OA\Property(property="token", type="string"),
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
    public function cadastrar(CadastrarPostRequest $request): JsonResponse
    {
        $dados = $request->payload();

        try {
            $usuarioEntity = $this->usuarioService->adicionar($dados);
        } catch (\Throwable $th) {
            return response()->json([
                'status' => false,
                'message' => $th->getMessage()
            ], 500);
        }

        return response()->json([
            'status' => 201,
            'message' => 'Usuário criado com sucesso',
            'token' => $this->usuarioService->criarToken($usuarioEntity)
        ], 201);
    }
}
