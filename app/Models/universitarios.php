<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class universitarios extends Model
{
    use HasFactory;

    protected $table = 'universitarios';
    protected $fillable = ['uni_nombre_1', 'uni_nombre_2', 'uni_apellido_1', 'uni_apellido_2', 'uni_numerodoc', 'uni_tipodoc', 'uni_semestreid', 'uni_carreraid'];
}
