<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class universitarios_asignados extends Model
{
    use HasFactory;

    protected $casts = [
        'uni_asig_universitariosid' => 'json', // declara el tipo json
    ];
}
