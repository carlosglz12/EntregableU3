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
            $table->json('medicamentos'); // guardar como JSON ya que no ocupa tabla
            $table->text('notas')->nullable();
            $table->timestamps();

            $table->foreign('paciente_id')->references('id')->on('pacientes')->onDelete('cascade');
            $table->foreign('cita_id')->references('id')->on('citas')->onDelete('set null');
        });

        Schema::create('consulta_servicio', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('consulta_id');
            $table->unsignedBigInteger('servicios_id');
            $table->text('notas')->nullable();
            $table->timestamps();

            $table->foreign('consulta_id')->references('id')->on('consultas')->onDelete('cascade');
            $table->foreign('servicios_id')->references('id')->on('servicios')->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('consulta_servicio');
        Schema::dropIfExists('consultas');
    }
};
