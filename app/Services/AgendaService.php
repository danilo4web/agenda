<?php

namespace App\Services;

use App\Entity\AgendaEntity;
use App\Exceptions\AgendaNotFoundException;
use App\Http\Resources\AgendaCollection;
use App\Repositories\Contracts\AgendaRepositoryInterface;
use Carbon\Carbon;

class AgendaService
{
    public function __construct(
        private AgendaRepositoryInterface $agendaRepository
    ) {
    }

    public function adicionarAgenda(array $dados): AgendaEntity
    {
        if ($this->isFinalDeSemana($dados['data_inicio']) || $this->isFinalDeSemana($dados['data_prazo'])) {
            throw new \DomainException('Não é permitido adicionar agendas aos finais de semana.');
        }

        if ($this->temAgendaConflitante($dados['data_inicio'], $dados['data_prazo'], $this->getUsuarioLogadoId())) {
            throw new \DomainException('Existe outra agenda para este periodo.');
        }

        $dados['usuario_id'] = $this->getUsuarioLogadoId();
        $agendaEntity = $this->agendaRepository->adicionar($dados);

        return $agendaEntity;
    }

    private function isFinalDeSemana($data): bool
    {
        $date = Carbon::parse($data);

        return $date->isWeekend();
    }

    public function temAgendaConflitante(string $dataInicio, string $dataPrazo, int $usuarioId): bool
    {
        return $this->agendaRepository->existeDataConflitante($dataInicio, $dataPrazo, $usuarioId);
    }

    public function atualizarAgenda(array $dados): AgendaEntity
    {
        if ($this->isFinalDeSemana($dados['data_inicio']) || $this->isFinalDeSemana($dados['data_prazo'])) {
            throw new \DomainException('Não é permitido adicionar agendas aos finais de semana.');
        }

        if ($this->temAgendaConflitante($dados['data_inicio'], $dados['data_prazo'], $this->getUsuarioLogadoId())) {
            throw new \DomainException('Existe outra agenda para este periodo.');
        }

        $dados['usuario_id'] = $this->getUsuarioLogadoId();
        $agendaEntity = $this->agendaRepository->adicionar($dados);

        return $agendaEntity;
    }

    public function filtrarAtividadesPorUsuario(array $data): AgendaCollection
    {
        return $this->agendaRepository->filtrarAgendaUsuarioPorData(
            $data['data_inicio'],
            $data['data_prazo'],
            $this->getUsuarioLogadoId()
        );
    }

    private function getUsuarioLogadoId(): int
    {
        return auth()->user()->id;
    }

    /**
     * @throws AgendaNotFoundException
     */
    public function removerAgenda(int $agendaId): bool
    {
        $agendaEntity = $this->agendaRepository->obter($agendaId);

        if ($agendaEntity->getUsuarioId() !== $this->getUsuarioLogadoId()) {
            throw new AgendaNotFoundException('Agenda não encontrada.');
        }

        if ($agendaEntity->getStatus() === AgendaEntity::STATUS_CONCLUIDO) {
            throw new \DomainException('Não é possível remover a agenda, a mesma está concluída.');
        }

        return $this->agendaRepository->remover($agendaId);
    }
}
