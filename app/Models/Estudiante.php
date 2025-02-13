<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Estudiante extends Model
{
    use HasFactory;

    protected $fillable = ['nombre', 'apellido', 'email', 'edad'];

    public function cursos()
    {
        return $this->belongsToMany(Curso::class, 'curso_estudiante');
    }
}
