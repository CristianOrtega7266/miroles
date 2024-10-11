<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMateriasTable extends Migration
{
    public function up()
    {
        Schema::create('materias', function (Blueprint $table) {
            $table->id(); // ID de la materia
            $table->string('nombre'); // Nombre de la materia
            $table->string('codigo', 10)->unique(); // Código de la materia, único
            $table->integer('creditos'); // Número de créditos de la materia
            $table->text('descripcion')->nullable(); // Descripción de la materia, puede ser nulo
            $table->integer('semestre'); // Semestre en el que se imparte
            $table->timestamps(); // Created_at y Updated_at
        });
    }

    public function down()
    {
        Schema::dropIfExists('materias'); // Borra la tabla si es necesario
    }
}
