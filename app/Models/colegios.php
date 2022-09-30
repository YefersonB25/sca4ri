<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class colegios extends Model
{
    use HasFactory;

    protected $table = 'colegios';
    protected $fillable = ['col_dane_colegio', 'col_nombre'];
}
