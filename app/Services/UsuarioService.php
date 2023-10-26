<?php

namespace App\Services;

use App\Entity\UsuarioEntity;
use App\Repositories\Contracts\UsuarioRepositoryInterface;

class UsuarioService
{
    public function __construct(
        private UsuarioRepositoryInterface $usuarioRepository
    ) {
    }

    public function adicionar(array $data): UsuarioEntity
    {
        return $this->usuarioRepository->adicionar($data);
    }

    public function atualizar(int $id, array $data): UsuarioEntity
    {
        return $this->usuarioRepository->atualizar($id, $data);
    }

    public function obterPorId(int $id): UsuarioEntity
    {
        return $this->usuarioRepository->obterPorId($id);
    }

    public function obterPorEmail(string $email): UsuarioEntity
    {
        return $this->usuarioRepository->obterPorEmail($email);
    }

    public function criarToken(UsuarioEntity $usuarioEntity): string
    {
        return $this->usuarioRepository->criarToken($usuarioEntity);
    }

    public function desativar(int $id): void
    {
        $this->usuarioRepository->desativar($id);
    }
}
