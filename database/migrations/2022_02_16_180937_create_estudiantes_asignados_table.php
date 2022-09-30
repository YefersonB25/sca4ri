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
        Schema::create('estudiantes_asignados', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('est_asig_cantidad')->nullable();
            $table->string('est_asig_nombre_grupo')->unique();
            $table->json('est_asig_estudianteid');
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
        Schema::dropIfExists('estudiantes_asignados');
    }
};
