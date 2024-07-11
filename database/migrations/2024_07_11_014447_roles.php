<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('roles', function (Blueprint $table) {
            $table->id();
            $table->string('name')->unique();
            $table->timestamps();
        });

        // Insertar roles predefinidos
        DB::table('roles')->insert([
            ['name' => 'administrador'],
            ['name' => 'doctor'],
            ['name' => 'secretaria'],
        ]);
    }

    public function down()
    {
        Schema::dropIfExists('roles');
    }
};
