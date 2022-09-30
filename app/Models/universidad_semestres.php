<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class universidad_semestres extends Model
{
    use HasFactory;
    
    protected $table = 'universidad_semestres';
    protected $fillable = ['semestre_carreraid', 'semestre_nombre'];
}
