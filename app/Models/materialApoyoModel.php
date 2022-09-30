<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class materialApoyoModel extends Model
{
    use HasFactory;

    protected $table = 'material_apoyo';
    protected $fillable = ['id_semillero', 'id_usuario', 'titulo', 'ubicacion_archivo'];
}
