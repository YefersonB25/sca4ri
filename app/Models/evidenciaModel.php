<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class evidenciaModel extends Model
{
    use HasFactory;

    protected $table = 'evidencias_semilleros';
    protected $fillable = ['id_semillero', 'id_objetivo', 'id_usuario', 'ubicacion_archivo'];
}
