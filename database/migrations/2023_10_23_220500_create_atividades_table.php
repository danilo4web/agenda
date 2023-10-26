<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAtividadesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('atividades', function (Blueprint $table) {
            $table->id();
            $table->date('data_inicio');
            $table->date('data_prazo');
            $table->date('data_conclusao')->nullable();
            $table->tinyInteger('status');
            $table->string('titulo');
            $table->text('descricao')->nullable();
            $table->foreignId('usuario_id')->constrained('usuarios');
            $table->foreignId('tipo_atividade_id')->constrained('tipo_atividades');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('agenda');
    }
}
