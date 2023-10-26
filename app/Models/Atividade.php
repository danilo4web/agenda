<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Atividade extends Model
{
    protected $fillable = [
        'data_inicio',
        'data_prazo',
        'data_conclusao',
        'status',
        'titulo',
        'tipo',
        'descricao',
        'usuario_id',
        'tipo_atividade_id'
    ];

    public function usuario(): BelongsTo
    {
        return $this->belongsTo(Usuario::class, 'usuario_id');
    }

    public function tipo(): HasOne
    {
        return $this->hasOne(TipoAtividade::class, 'tipo_atividade_id');
    }
}
