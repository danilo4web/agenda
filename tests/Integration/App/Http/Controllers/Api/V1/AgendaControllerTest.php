<?php

namespace Tests\App\Http\Controllers\API;

use App\Models\TipoAtividade;
use App\Models\Usuario;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class AgendaControllerTest extends TestCase
{
    use RefreshDatabase;
    use WithFaker;

    private $usuario;
    private $tipoAtividade;

    public function setUp(): void
    {
        parent::setUp();

        $this->usuario = Usuario::factory()->create();
        $this->tipoAtividade = TipoAtividade::factory()->create();
    }

    public function testDeveAdicionarAtividade()
    {
        $this->actingAs($this->usuario);

        $response = $this->postJson('/api/v1/agendas/adicionar', [
            'data_inicio' => now()->next('Monday')->format('Y-m-d'),
            'data_prazo' => now()->next('Friday')->format('Y-m-d'),
            'status' => 1,
            'titulo' => $this->faker->sentence,
            'descricao' => $this->faker->text,
            'tipo_atividade_id' => $this->tipoAtividade->id,
        ]);

        $response->assertStatus(201)
            ->assertJson([
                'message' => 'Atividade adicionada com sucesso.',
            ]);
    }

    public function testNaoDevePermitirAdicionarAtividadeSemAutenticacao()
    {
        $response = $this->postJson('/api/v1/agendas/adicionar', [
            'data_inicio' => now()->next('Monday')->format('Y-m-d'),
            'data_prazo' => now()->next('Friday')->format('Y-m-d'),
            'status' => 1,
            'titulo' => $this->faker->sentence,
            'tipo_atividade_id' => 1
        ]);

        $response->assertStatus(401);
    }

    public function testDeveFiltrarAsAtividades()
    {
        $this->actingAs($this->usuario);

        $dataInicio = now()->next('Monday')->format('Y-m-d');
        $dataPrazo = now()->next('Friday')->format('Y-m-d');
        $titulo = $this->faker->sentence;
        $descricao = $this->faker->text;

        $this->postJson('/api/v1/agendas/adicionar', [
            'data_inicio' => $dataInicio,
            'data_prazo' => $dataPrazo,
            'status' => 1,
            'titulo' => $titulo,
            'descricao' => $descricao,
            'tipo_atividade_id' => $this->tipoAtividade->id,
        ]);

        $response = $this->postJson('/api/v1/agendas/filtrar', [
            'data_inicio' => now()->format('Y-m-d'),
            'data_prazo' => now()->addWeeks(2),
        ]);

        $response->assertStatus(200)
            ->assertJson([
                [
                    'data_inicio' => $dataInicio,
                    'data_prazo' => $dataPrazo,
                    'status' => 1,
                    'titulo' => $titulo,
                    'descricao' => $descricao,
                    'tipo_atividade_id' => $this->tipoAtividade->id,
                ],
            ]);
    }
}
