<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class estudiantes_asignados extends Model
{
    use HasFactory;

    protected $casts = [
        'est_asig_estudianteid' => 'array', // declara el tipo json
    ];
}
