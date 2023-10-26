<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\Agenda\{FiltrarAtividadesRequest, AdicionarAtividadeRequest, AtualizarAtividadeRequest};
use App\Services\{AgendaService, LogService};
use Illuminate\Http\JsonResponse;
use App\Exceptions\AgendaNotFoundException;

/**
 * @OA\Info(title="Agenda API ",version="1.0.0")
 */
class AgendaController extends Controller
{
    /**
     *  @OA\Server(
     *      url="http://0.0.0.0:8080",
     *      description="Local Server"
     *  )
     *  @OA\SecurityScheme(
     *      type="http",
     *      name="Autorização",
     *      description="Token de acesso obtido na autenticação",
     *      in="header",
     *      scheme="bearer",
     *      bearerFormat="JWT",
     *      securityScheme="bearerToken",
     *  )
     */
    public function __construct(
        private AgendaService $agendaService,
        private LogService $logService
    ) {
    }

    /**
     * @OA\Post(
     *      path="/api/v1/agendas/adicionar",
     *      summary="Adiciona nova atividade na agenda.",
     *      operationId="adicionarAtividade",
     *      tags={"Agendas"},
     *      summary="Adiioncar nova atividade na agenda.",
     *      security={ {"bearerToken":{}} },
     *      @OA\RequestBody(
     *          required=true,
     *          description="Dados da requisição.",
     *          @OA\JsonContent(
     *              required={"data_inicio", "data_prazo", "status", "titulo", "descricao", "tipo_atividade_id"},
     *              @OA\Property(property="data_inicio", type="string", format="date", example="2023-10-30"),
     *              @OA\Property(property="data_prazo", type="string", format="date", example="2023-11-10"),
     *              @OA\Property(property="status", type="integer", example=1),
     *              @OA\Property(property="titulo", type="string", example="Minha Atividade"),
     *              @OA\Property(property="descricao", type="string", example="Descrição da atividade"),
     *              @OA\Property(property="tipo_atividade_id", type="integer", example=1),
     *          ),
     *      ),
     *      @OA\Response(
     *          response=201,
     *          description="Atividade adicionada com sucesso.",
     *          @OA\JsonContent(
     *              @OA\Property(property="message", type="string", example="Atividade adicionada com sucesso."),
     *          ),
     *      ),
     *      @OA\Response(
     *          response=409,
     *          description="Conflito de domínio.",
     *          @OA\JsonContent(
     *              @OA\Property(property="message", type="string", example="Conflito de domínio."),
     *          ),
     *      ),
     *      @OA\Response(
     *          response=500,
     *          description="Erro interno do servidor.",
     *          @OA\JsonContent(
     *              @OA\Property(property="message", type="string", example="Houve um erro não esperado."),
     *          ),
     *      )
     * )
     */
    public function adicionarAtividade(AdicionarAtividadeRequest $request): JsonResponse
    {
        $input = $request->payload();

        try {
            $this->agendaService->adicionarAgenda($input);
        } catch (\DomainException $e) {
            return response()->json(['message' => $e->getMessage()], 409);
        } catch (\Exception $e) {
            $this->logService->logException($e);
            return response()->json(['message' => 'Houve um erro não esperado'], 500);
        }

        return response()->json(['message' => 'Atividade adicionada com sucesso.'], 201);
    }

    /**
     * @OA\Put(
     *      path="/api/v1/agendas/atualizar",
     *      operationId="atualizarAtividade",
     *      tags={"Agendas"},
     *      summary="Atualiza uma atividade na agenda.",
     *      security={ {"bearerToken":{}} },
     *      @OA\RequestBody(
     *          required=true,
     *          description="Dados da atividade",
     *          @OA\JsonContent(
     *              required={"data_inicio", "data_prazo", "status", "titulo", "descricao", "tipo_atividade_id"},
     *              @OA\Property(property="data_inicio", type="string", format="date", example="2023-10-30"),
     *              @OA\Property(property="data_prazo", type="string", format="date", example="2023-11-10"),
     *              @OA\Property(property="status", type="integer", example=1),
     *              @OA\Property(property="titulo", type="string", example="Minha Atividade Atualizada"),
     *              @OA\Property(property="descricao", type="string", example="Descrição atualizada da atividade"),
     *              @OA\Property(property="tipo_atividade_id", type="integer", example=1),
     *          ),
     *      ),
     *      @OA\Response(
     *          response=200,
     *          description="Atividade atualizada com sucesso.",
     *          @OA\JsonContent(
     *              @OA\Property(property="message", type="string", example="Atividade atualizada com sucesso."),
     *          ),
     *      ),
     *      @OA\Response(
     *          response=409,
     *          description="Conflito de domínio.",
     *          @OA\JsonContent(
     *              @OA\Property(property="message", type="string", example="Conflito de domínio."),
     *          ),
     *      ),
     *      @OA\Response(
     *          response=500,
     *          description="Erro interno do servidor.",
     *          @OA\JsonContent(
     *              @OA\Property(property="message", type="string", example="Houve um erro não esperado."),
     *          ),
     *      )
     * )
     */
    public function atualizarAtividade(AtualizarAtividadeRequest $request): JsonResponse
    {
        $input = $request->payload();

        try {
            $this->agendaService->atualizarAgenda($input);
        } catch (\DomainException $e) {
            return response()->json(['message' => $e->getMessage()], 409);
        } catch (\Exception $e) {
            $this->logService->logException($e);
            return response()->json(['message' => 'Houve um erro não esperado'], 500);
        }

        return response()->json(['message' => 'Atividade atualizada com sucesso.']);
    }

    /**
     * Filtra as atividades do usuário com base nos parâmetros fornecidos.
     *
     * @OA\Post(
     *      path="/api/v1/agendas/filtrar",
     *      operationId="filtrarAtividades",
     *      tags={"Agendas"},
     *      summary="Filtra as atividades do usuário.",
     *      security={ {"bearerToken":{}} },
     *      @OA\RequestBody(
     *          required=true,
     *          description="Parâmetros de filtragem",
     *          @OA\JsonContent(
     *              @OA\Property(property="data_inicio", type="string", format="date", example="2023-01-01"),
     *              @OA\Property(property="data_prazo", type="string", format="date", example="2023-01-31"),
     *          ),
     *      ),
     *      @OA\Response(
     *          response=200,
     *          description="Lista de atividades filtradas.",
     *      ),
     *      @OA\Response(
     *          response=422,
     *          description="Erro de validação.",
     *          @OA\JsonContent(
     *              @OA\Property(property="success", type="boolean", example=false),
     *              @OA\Property(property="message", type="string", example="Erros de validação encontrados."),
     *              @OA\Property(property="errors", type="object", example={"data_inicio": {"Data obrigatória"}}),
     *          ),
     *      )
     * )
     */
    public function filtrarAtividades(FiltrarAtividadesRequest $request): JsonResponse
    {
        $input = $request->payloadData();

        $agendasCollection = $this->agendaService->filtrarAtividadesPorUsuario($input);

        return response()->json($agendasCollection->toArray(), 200);
    }

    /**
     * @OA\Delete(
     *      path="/api/agendas/remover/{agendaId}",
     *      operationId="removerAtividade",
     *      tags={"Agendas"},
     *      summary="Remove uma atividade da agenda.",
     *      security={ {"bearerToken":{}} },
     *      @OA\Parameter(
     *          name="agendaId",
     *          in="path",
     *          required=true,
     *          description="ID da atividade a ser removida",
     *          @OA\Schema(type="integer"),
     *      ),
     *      @OA\Response(
     *          response=200,
     *          description="Atividade removida com sucesso.",
     *          @OA\JsonContent(
     *              @OA\Property(property="message", type="string", example="Atividade removida com sucesso."),
     *          ),
     *      ),
     *      @OA\Response(
     *          response=404,
     *          description="Atividade não encontrada.",
     *          @OA\JsonContent(
     *              @OA\Property(property="message", type="string", example="Atividade não encontrada."),
     *          ),
     *      ),
     *      @OA\Response(
     *          response=500,
     *          description="Erro interno do servidor.",
     *          @OA\JsonContent(
     *              @OA\Property(property="message", type="string", example="Houve um erro não esperado."),
     *          ),
     *      ),
     * )
     */
    public function removerAtividade(int $agendaId): JsonResponse
    {
        try {
            $this->agendaService->removerAgenda($agendaId);
        } catch (\DomainException | AgendaNotFoundException $e) {
            return response()->json(['message' => $e->getMessage()], $e->getCode());
        } catch (\Exception $e) {
            $this->logService->logException($e);
            return response()->json(['message' => 'Houve um erro não esperado'], 500);
        }

        return response()->json(['message' => 'Atividade removida com sucesso.'], 204);
    }
}
