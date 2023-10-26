<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class TipoAtividade extends Model
{
    use HasFactory;

    protected $fillable = [
        'titulo',
        'descricao',
        'status'
    ];

    public function atividades(): BelongsToMany
    {
        return $this->belongsToMany(Atividade::class, 'usuario_id');
    }
}
