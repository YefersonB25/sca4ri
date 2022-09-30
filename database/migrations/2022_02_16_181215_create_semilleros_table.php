<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('semilleros', function (Blueprint $table) {
            $table->increments('id');
            $table->string('sem_nombre', 256);
            $table->text('sem_descripcion', 256)->nullable();
            $table->json('sem_objetivo');
            $table->date('sem_fechainicio');
            $table->date('sem_fechafin');
            $table->integer('sem_catid')->nullable();
            $table->enum('sem_estado', array('Activo','En espera','Finalizado'));
            $table->foreignId('sem_grupo_est');
            $table->foreignId('sem_grupo_uni');
            $table->foreignId('sem_grupo_profe');
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
        Schema::dropIfExists('semilleros');
    }
};
