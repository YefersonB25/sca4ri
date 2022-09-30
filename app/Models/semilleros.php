<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class semilleros extends Model
{
    use HasFactory;

    protected $table = 'semilleros';
    protected $casts = [
        'sem_objetivo' => 'json', // declara el tipo json
    ];
}
