<?php

namespace App\Repositories\Eloquent;

use App\Entity\UsuarioEntity;
use App\Models\Usuario;
use App\Repositories\Contracts\UsuarioRepositoryInterface;

class UsuarioRepository extends AbstractRepository implements UsuarioRepositoryInterface
{
    protected string $model = Usuario::class;

    public function adicionar(array $data): UsuarioEntity
    {
        $usuarioModel = parent::store($data);

        return UsuarioEntity::fromArray($usuarioModel->toArray());
    }

    public function atualizar(int $id, array $data): UsuarioEntity
    {
        return parent::find($id)->update($data);
        return UsuarioEntity::fromArray($usuarioModel->toArray());
    }

    public function obterPorId(int $id): UsuarioEntity
    {
        $usuarioModel = $this->find($id);
        return UsuarioEntity::fromArray($usuarioModel->toArray());
    }

    public function obterPorEmail(string $email): UsuarioEntity
    {
        $usuarioModel = $this->model::where('email', $email)->first();

        return UsuarioEntity::fromArray($usuarioModel->toArray());
    }

    public function criarToken(UsuarioEntity $usuarioEntity): string
    {
        $usuarioModel = $this->model::where('email', $usuarioEntity->getEmail())->first();

        return $usuarioModel->createToken("API TOKEN")->plainTextToken;
    }

    public function desativar(int $id): void
    {
        parent::find($id)->update(['status' => 0]);
    }
}
