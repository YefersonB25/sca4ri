<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class profesores extends Model
{
    use HasFactory;

    protected $table = 'profesores';
    protected $fillable = ['profe_nombre', 'dane_empresa', 'profe_numerodoc', 'empresa'];
}
