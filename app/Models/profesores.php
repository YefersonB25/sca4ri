<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\colegios;
use App\Models\universidades;

class profesores extends Model
{
    use HasFactory;

    protected $table = 'profesores';
    protected $fillable = ['profe_nombre', 'dane_empresa', 'profe_numerodoc', 'empresa'];

    public function empresanombre(){
        if($this->empresa == 1){
            return $this->hasOne(colegios::class, 'col_dane_colegio', 'dane_empresa');
        }else
            return $this->hasOne(universidades::class, 'uni_codigo', 'dane_empresa');
             
    }
}
