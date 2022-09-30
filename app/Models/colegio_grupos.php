<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class colegio_grupos extends Model
{
    use HasFactory;

    protected $table = 'colegio_grupos';
    protected $fillable = ['sede_codigo', 'grupo_nombre', 'grupo_jornada' ,'grupo_cursoid'];
}
