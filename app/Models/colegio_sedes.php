<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class colegio_sedes extends Model
{
    use HasFactory;

    protected $table = 'colegio_sedes';

    protected $fillable = ['sede_danecolegio', 'sede_codigo', 'sede_nombre'];
}
