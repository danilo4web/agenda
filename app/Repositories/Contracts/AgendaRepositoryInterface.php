<?php

namespace App\Repositories\Contracts;

use App\Entity\AgendaEntity;
use App\Http\Resources\AgendaCollection;

interface AgendaRepositoryInterface
{
    public function filtrarAgendaUsuarioPorData(
        string $dataInicio,
        string $dataPrazo,
        int $usuarioId
    ): AgendaCollection;

    public function obter(int $agendaId): AgendaEntity;

    public function adicionar(array $dados): AgendaEntity;

    public function atualizar(int $agendaId, array $dados): AgendaEntity;

    public function remover(int $agendaId): bool;
}
