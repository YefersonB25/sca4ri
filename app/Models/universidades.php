<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class universidades extends Model
{
    use HasFactory;
    
    protected $table = 'universidades';
    protected $fillable = ['uni_codigo', 'uni_nombre']; 
}
