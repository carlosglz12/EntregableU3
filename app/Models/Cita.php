<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cita extends Model
{
    use HasFactory;

    protected $fillable = [
        'paciente_id',
        'doctor_id',
        'fecha',
        'hora',
        'estado'
    ];

    public function paciente()
    {
        return $this->belongsTo(Pacientes::class);
    }

    public function doctor()
    {
        return $this->belongsTo(Doctores::class);
    }
}
