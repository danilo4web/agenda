<?php

namespace App\Http\Requests\Agenda;

use App\Http\Requests\AbstractFormRequest;

class FiltrarAtividadesRequest extends AbstractFormRequest
{
    public function rules()
    {
        return [
            'data_inicio' => 'nullable|date',
            'data_prazo' => 'nullable|date',
        ];
    }

    public function payloadData(): array
    {
        return [
            'data_inicio' => $this->input('data_inicio'),
            'data_prazo' => $this->input('data_prazo'),
        ];
    }
}
