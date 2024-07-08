<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('consultas', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('paciente_id');
            $table->unsignedBigInteger('cita_id')->nullable();
            $table->decimal('peso', 5, 2);
            $table->decimal('talla', 5, 2);
            $table->decimal('temperatura', 4, 2);
            $table->decimal('saturacion', 5, 2);
            $table->integer('frecuencia_cardiaca');
            $table->decimal('altura', 5, 2);
            $table->text('motivo_consulta');
            $table->text('padecimiento');
            $table->text('medicamentos'); // Guardar como JSON
            $table->text('notas')->nullable();
            $table->timestamps();

            $table->foreign('paciente_id')->references('id')->on('pacientes')->onDelete('cascade');
            $table->foreign('cita_id')->references('id')->on('citas')->onDelete('set null');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('consultas');
    }
};
