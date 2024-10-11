<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Materia extends Model
{
    use HasFactory;

    protected $fillable = [
        'nombre',         // Nombre de la materia
        'codigo',         // Código de la materia
        'creditos',       // Créditos de la materia
        'descripcion',    // Descripción de la materia
        'semestre',       // Semestre en el que se imparte la materia
    ];
}
