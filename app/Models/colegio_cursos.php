<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class colegio_cursos extends Model
{
    use HasFactory;

    protected $table = 'colegio_cursos';
    protected $fillable = ['curso_nombre', 'curso_sedeid'];
}
