<?php

namespace App\Repositories\Contracts;

use App\Entity\UsuarioEntity;

interface UsuarioRepositoryInterface
{
    public function obterPorId(int $id): UsuarioEntity;

    public function adicionar(array $data): UsuarioEntity;

    public function atualizar(int $id, array $data): UsuarioEntity;

    public function desativar(int $id): void;

    public function obterPorEmail(string $email): UsuarioEntity;

    public function criarToken(UsuarioEntity $usuarioEntity): string;
}
