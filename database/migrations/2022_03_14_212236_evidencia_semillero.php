<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class EvidenciaSemillero extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('evidencias_semilleros', function (Blueprint $table) {
            $table->id();
            $table->foreignId('id_semillero');
            $table->foreignId('id_objetivo');
            $table->foreignId('id_usuario');
            $table->text('ubicacion_archivo');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('evidencias_semilleros');
    }
}
