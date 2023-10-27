<?php

namespace Database\Seeders;

use App\Models\TipoAtividade;
use App\Models\v2\UserType;
use Illuminate\Database\Seeder;

class TipoAtividadeTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        TipoAtividade::create([
            'id' => 1,
            'titulo' => 'Compromisso',
            'descricao' => 'Utilizado para compromissos',
            'status' => 1
        ]);

        TipoAtividade::create([
            'id' => 2,
            'titulo' => 'Reunião',
            'descricao' => 'Utilizado para reuniões',
            'status' => 2
        ]);

        TipoAtividade::create([
            'id' => 3,
            'titulo' => 'Tarefa',
            'descricao' => 'Utilizado para tarefas',
            'status' => 1
        ]);
    }
}
