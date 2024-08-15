<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Venta extends Model
{
    protected $fillable = ['paciente_id', 'subtotal', 'total'];

    public function productos()
    {
        return $this->hasMany(ProductoVenta::class);
    }

    public function paciente()
    {
        return $this->belongsTo(Pacientes::class);
    }
}

