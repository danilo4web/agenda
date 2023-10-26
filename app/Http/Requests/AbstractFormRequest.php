<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class AbstractFormRequest extends FormRequest
{
    public function failedValidation(Validator $validator): HttpResponseException
    {
        throw new HttpResponseException(response()->json([
            'success' => false,
            'message' => 'Erros encontrados:',
            'data' => $validator->errors()
        ], 422));
    }
}
