<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('citas', function (Blueprint $table) {
            $table->id();
            $table->foreignId('paciente_id')->constrained('pacientes')->onDelete('cascade');
            $table->foreignId('doctor_id')->constrained('doctores')->onDelete('cascade');
            $table->date('fecha');
            $table->time('hora');
            $table->string('estado')->default('en proceso');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('citas');
    }
};
