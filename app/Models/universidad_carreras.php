<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class universidad_carreras extends Model
{
    use HasFactory;

    protected $table = 'universidad_carreras';
    protected $fillable = ['carrera_codigo', 'carrera_nombre', 'carrera_sedeid'];
}
