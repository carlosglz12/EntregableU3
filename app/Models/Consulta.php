<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Consulta extends Model
{
    use HasFactory;

    protected $fillable = [
        'paciente_id',
        'cita_id',
        'peso',
        'talla',
        'temperatura',
        'saturacion',
        'frecuencia_cardiaca',
        'altura',
        'motivo_consulta',
        'padecimiento',
        'medicamentos',
        'notas'
    ];

    protected $casts = [
        'medicamentos' => 'array',
    ];

    public function paciente()
    {
        return $this->belongsTo(Pacientes::class);
    }

    public function cita()
    {
        return $this->belongsTo(Cita::class);
    }
    
    public function servicios()
    {
        return $this->belongsToMany(Servicios::class, 'consulta_servicio')->withPivot('notas');
    }
}
