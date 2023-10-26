<?php

namespace App\Http\Requests\Agenda;

use App\Http\Requests\AbstractFormRequest;

class AtualizarAtividadeRequest extends AbstractFormRequest
{
    public function rules()
    {
        return [
            'data_inicio' => 'required|date',
            'data_prazo' => 'nullable|date',
            'data_conclusao' => 'nullable|date',
            'status' => 'required|int',
            'titulo' => 'required|string|max:100',
            'descricao' => 'nullable|string',
            'usuario_id' => 'required|int|exists:usuarios,id',
            'tipo_atividade_id' => 'required|int|exists:tipo_atividades,id'
        ];
    }

    public function payload(): array
    {
        return [
            'data_inicio' => $this->input('data_inicio'),
            'data_prazo' => $this->input('data_prazo'),
            'data_conclusao' => $this->input('data_conclusao'),
            'status' => $this->input('status'),
            'titulo' => $this->input('titulo'),
            'descricao' => $this->input('descricao'),
            'usuario_id' => $this->input('usuario_id'),
            'tipo_atividade_id' => $this->input('tipo_atividade_id')
        ];
    }
}
