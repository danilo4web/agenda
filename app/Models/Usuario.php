<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class Usuario extends Authenticatable
{
    use HasApiTokens;
    use HasFactory;
    use Notifiable;

    protected $fillable = [
        'nome',
        'email',
        'status',
        'password'
    ];

    protected $hidden = [

        'remember_token',
    ];

    public function atividades()
    {
        return $this->hasMany(Atividade::class, 'usuario_id');
    }
}
