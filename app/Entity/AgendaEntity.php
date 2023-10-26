<?php

namespace App\Entity;

class AgendaEntity
{
    public function __construct(
        private string $dataInicio,
        private string $dataPrazo,
        private ?string $dataConclusao,
        private int $status,
        private string $titulo,
        private string $descricao,
        private int $usuarioId,
        private int $tipoAtividadeId
    ) {
    }

    public const STATUS_ABERTO = 1;
    public const STATUS_CONCLUIDO = 2;
    public const STATUS_INATIVO = 0;

    public static function fromArray(array $data): self
    {
        if (!isset($data['data_inicio'])) {
            dd($data);
        }

        return new self(
            $data['data_inicio'],
            $data['data_prazo'] ?? null,
            $data['data_conclusao'] ?? null,
            $data['status'],
            $data['titulo'],
            $data['descricao'] ?? null,
            $data['usuario_id'],
            $data['tipo_atividade_id']
        );
    }

    /**
     * @return string
     */
    public function getDataInicio(): string
    {
        return $this->dataInicio;
    }

    /**
     * @param string $dataInicio
     * @return AgendaEntity
     */
    public function setDataInicio(string $dataInicio): AgendaEntity
    {
        $this->dataInicio = $dataInicio;
        return $this;
    }

    /**
     * @return string
     */
    public function getDataPrazo(): string
    {
        return $this->dataPrazo;
    }

    /**
     * @param string $dataPrazo
     * @return AgendaEntity
     */
    public function setDataPrazo(string $dataPrazo): AgendaEntity
    {
        $this->dataPrazo = $dataPrazo;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getDataConclusao(): ?string
    {
        return $this->dataConclusao;
    }

    /**
     * @param string|null $dataConclusao
     * @return AgendaEntity
     */
    public function setDataConclusao(?string $dataConclusao): AgendaEntity
    {
        $this->dataConclusao = $dataConclusao;
        return $this;
    }

    /**
     * @return int
     */
    public function getStatus(): int
    {
        return $this->status;
    }

    /**
     * @param int $status
     * @return AgendaEntity
     */
    public function setStatus(int $status): AgendaEntity
    {
        $this->status = $status;
        return $this;
    }

    /**
     * @return string
     */
    public function getTitulo(): string
    {
        return $this->titulo;
    }

    /**
     * @param string $titulo
     * @return AgendaEntity
     */
    public function setTitulo(string $titulo): AgendaEntity
    {
        $this->titulo = $titulo;
        return $this;
    }

    /**
     * @return string
     */
    public function getDescricao(): string
    {
        return $this->descricao;
    }

    /**
     * @param string $descricao
     * @return AgendaEntity
     */
    public function setDescricao(string $descricao): AgendaEntity
    {
        $this->descricao = $descricao;
        return $this;
    }

    /**
     * @return int
     */
    public function getUsuarioId(): int
    {
        return $this->usuarioId;
    }

    /**
     * @param int $usuarioId
     * @return AgendaEntity
     */
    public function setUsuarioId(int $usuarioId): AgendaEntity
    {
        $this->usuarioId = $usuarioId;
        return $this;
    }

    /**
     * @return int
     */
    public function getTipoAtividadeId(): int
    {
        return $this->tipoAtividadeId;
    }

    /**
     * @param int $tipoAtividadeId
     * @return AgendaEntity
     */
    public function setTipoAtividadeId(int $tipoAtividadeId): AgendaEntity
    {
        $this->tipoAtividadeId = $tipoAtividadeId;
        return $this;
    }

    public function toArray(): array
    {
        return [
            'data_inicio' => $this->getDataInicio(),
            'data_prazo' => $this->getDataPrazo(),
            'data_conclusao' => $this->getDataConclusao(),
            'status' => $this->getStatus(),
            'titulo' => $this->getTitulo(),
            'descricao' => $this->getDescricao(),
            'usuario_id' => $this->getUsuarioId(),
            'tipo_atividade_id' => $this->getUsuarioId(),
        ];
    }
}
