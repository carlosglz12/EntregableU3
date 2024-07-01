<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('pacientes', function (Blueprint $table) {
            $table->id();
            $table->string('nombres');
            $table->string('apellidos');
            $table->string('correo')->unique();
            $table->bigInteger('telefono');
            $table->bigInteger('telefono_emergencia');
            $table->string('genero');
            $table->date('fecha_nacimiento');
            $table->text('notas')->nullable();
            $table->rememberToken();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('pacientes');
    }
};
