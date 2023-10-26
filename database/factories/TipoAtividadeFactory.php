<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class TipoAtividadeFactory extends Factory
{
    public function definition()
    {
        return [
            'titulo' => $this->faker->title,
            'descricao' => $this->faker->text,
            'status' => 1
        ];
    }
}
