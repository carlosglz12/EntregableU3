<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductoVenta extends Model
{
    protected $fillable = ['venta_id', 'servicio_id', 'cantidad', 'precio'];

    public function venta()
    {
        return $this->belongsTo(Venta::class);
    }

    public function servicio()
    {
        return $this->belongsTo(Servicios::class);
    }
}
