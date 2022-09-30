<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class estudiantes extends Model
{
    use HasFactory;

    protected $table = 'estudiantes';
    protected $fillable = ['est_numerodoc', 'est_tipodoc', 'est_nombre_1', 'est_nombre_2', 'est_apellido_1', 'est_apellido_2','est_grupoid'];
}
