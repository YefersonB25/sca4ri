<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Objetivos extends Model
{
    use HasFactory;

    protected $table = 'objetivos';
    protected $fillable = ['objetivo_categoria', 'objetivo_nombre', 'objetivo_descripcion'];
}
