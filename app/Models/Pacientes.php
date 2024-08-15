<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class Pacientes extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'nombres',
        'apellidos',
        'correo',
        'telefono',
        'telefono_emergencia',
        'fecha_nacimiento',
        'genero',
        'notas'
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $dates = [
        'fecha_nacimiento' => 'date',
    ];
    
    public function consultas()
    {
        return $this->hasMany(Consulta::class, 'paciente_id');
    }
}
