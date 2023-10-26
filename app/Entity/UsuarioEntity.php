<?php

namespace App\Entity;

class UsuarioEntity
{
    public function __construct(
        private string $nome,
        private string $email,
        private ?string $password,
        private ?int $status
    ) {
    }

    public static function fromArray(array $data): self
    {
        return new self(
            $data['nome'],
            $data['email'],
            $data['password'] ?? null,
            $data['status'] ?? 1
        );
    }

    /**
     * @return string
     */
    public function getNome(): string
    {
        return $this->nome;
    }

    /**
     * @param string $nome
     * @return UsuarioEntity
     */
    public function setNome(string $nome): UsuarioEntity
    {
        $this->nome = $nome;
        return $this;
    }

    /**
     * @return string
     */
    public function getEmail(): string
    {
        return $this->email;
    }

    /**
     * @param string $email
     * @return UsuarioEntity
     */
    public function setEmail(string $email): UsuarioEntity
    {
        $this->email = $email;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getPassword(): ?string
    {
        return $this->password;
    }

    /**
     * @param string|null $password
     * @return UsuarioEntity
     */
    public function setPassword(?string $password): UsuarioEntity
    {
        $this->password = $password;
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
     * @return UsuarioEntity
     */
    public function setStatus(int $status): UsuarioEntity
    {
        $this->status = $status;
        return $this;
    }

    public function toArray(): array
    {
        return [
            'nome' => $this->nome,
            'email' => $this->email,
            'status' => $this->status
        ];
    }
}
