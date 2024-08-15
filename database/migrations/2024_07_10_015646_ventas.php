<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{

    public function up(): void
    {
        Schema::create('ventas', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('paciente_id')->nullable(); 
            $table->decimal('subtotal', 8, 2);
            $table->decimal('total', 8, 2);
            $table->timestamps();
        
            $table->foreign('paciente_id')->references('id')->on('pacientes')->onDelete('set null');
        });
        
        Schema::create('producto_venta', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('venta_id');
            $table->unsignedBigInteger('servicio_id');
            $table->integer('cantidad');
            $table->decimal('precio', 8, 2);
            $table->timestamps();
        
            $table->foreign('venta_id')->references('id')->on('ventas')->onDelete('cascade');
            $table->foreign('servicio_id')->references('id')->on('servicios')->onDelete('cascade');
        });
        
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
    }
};
