<?php

namespace App\Http\Requests\Usuario;

use App\Http\Requests\AbstractFormRequest;
use Illuminate\Support\Facades\Hash;

class CadastrarPostRequest extends AbstractFormRequest
{
    public function rules(): array
    {
        return [
            'nome' => 'required',
            'email' => 'required|email|unique:usuarios,email',
            'password' => 'required'
        ];
    }

    public function messages(): array
    {
        return [
            'email.unique' => 'E-mail já cadastrado!',
            'email.email' => 'Deve ser um email válido',
        ];
    }

    public function payload(): array
    {
        return [
            'nome' => $this->nome,
            'email' => $this->email,
            'password' => Hash::make($this->password)
        ];
    }
}
