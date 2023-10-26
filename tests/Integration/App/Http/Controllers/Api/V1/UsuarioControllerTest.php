<?php

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class UsuarioControllerTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    public function testDeveCadastrarUmNovoUsuario()
    {
        $userData = [
            'nome' => $this->faker->name,
            'email' => $this->faker->unique()->safeEmail,
            'password' => 'secret123',
        ];

        $response = $this->postJson('/api/usuarios/cadastrar', $userData);

        $response->assertStatus(201)
            ->assertJson([
                'status' => 201,
                'message' => 'Usuário criado com sucesso',
            ])
            ->assertJsonStructure(['token']);
    }

    public function testNaoDeveCadastrarUsuarioComEmailInvalido()
    {
        $userData = ['nome' => $this->faker->name, 'email' => 'invalid-email', 'password' => 'secret123'];

        $response = $this->postJson('/api/usuarios/cadastrar', $userData);

        $response->assertStatus(422)
            ->assertJsonFragment([
                'success' => false,
                'data' => [
                    'email' => [
                        'Deve ser um email válido'
                    ]
                ]
            ]);
    }
}
