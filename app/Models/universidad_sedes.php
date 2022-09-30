<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class universidad_sedes extends Model
{
    use HasFactory;

    protected $table = 'universidad_sedes';
    protected $fillable = ['sede_codigo', 'sede_nombre', 'sede_universidadid'];
}
