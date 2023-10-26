<?php

namespace App\Repositories\Eloquent;

use App\Entity\AgendaEntity;
use App\Http\Resources\AgendaCollection;
use App\Models\Atividade;
use App\Repositories\Contracts\AgendaRepositoryInterface;

class AgendaRepository extends AbstractRepository implements AgendaRepositoryInterface
{
    protected string $model = Atividade::class;

    public function filtrarAgendaUsuarioPorData(
        string $dataInicio,
        string $dataPrazo,
        int $usuarioId
    ): AgendaCollection {
        $agendas = $this->model::where('data_inicio', '>=', $dataInicio)
            ->where('data_prazo', '<=', $dataPrazo)
            ->where('usuario_id', $usuarioId)
            ->where('status', '<>', AgendaEntity::STATUS_INATIVO)
            ->get();

        return AgendaCollection::makeFromAgendas($agendas->toArray());
    }

    public function existeDataConflitante(string $dataInicio, string $dataPrazo, int $usuarioId): bool
    {
        return $this->model::where('usuario_id', $usuarioId)
            ->where('status', '<>', AgendaEntity::STATUS_INATIVO)
            ->where(function ($query) use ($dataInicio, $dataPrazo) {
                $query->where(function ($subquery) use ($dataInicio, $dataPrazo) {
                    $subquery->where('data_inicio', '<=', $dataPrazo)
                        ->where('data_prazo', '>=', $dataInicio);
                })->orWhere(function ($subquery) use ($dataInicio, $dataPrazo) {
                    $subquery->where('data_inicio', '>=', $dataInicio)
                        ->where('data_inicio', '<=', $dataPrazo);
                });
            })->exists();
    }

    public function obter(int $agendaId): AgendaEntity
    {
        $agenda = $this->model::find($agendaId);

        if (!$agenda) {
            throw new \DomainException('Atividade não encontrada.');
        }

        return AgendaEntity::fromArray($agenda->toArray());
    }

    public function adicionar(array $dados): AgendaEntity
    {
        $agenda = parent::store($dados);

        return AgendaEntity::fromArray($agenda->toArray());
    }

    public function atualizar(int $agendaId, array $dados): AgendaEntity
    {
        $agenda = $this->model::find($agendaId);

        if (!$agenda) {
            throw new \DomainException('Atividade não encontrada.');
        }

        if ($agenda->status === AgendaEntity::STATUS_INATIVO) {
            throw new \DomainException('Atividade inativa');
        }

        $agenda->update($dados);

        return AgendaEntity::fromArray($agenda->toArray());
    }

    public function remover(int $agendaId): bool
    {
        $agenda = $this->model::find($agendaId);

        if (!$agenda) {
            throw new \DomainException('Atividade não encontrada.');
        }

        $agenda->status = AgendaEntity::STATUS_INATIVO;
        $agenda->save();

        return true;
    }
}
