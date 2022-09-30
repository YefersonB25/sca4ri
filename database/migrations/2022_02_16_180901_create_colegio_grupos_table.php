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
        Schema::create('colegio_grupos', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('sede_codigo');
            $table->string('grupo_nombre', 256);
            $table->string('grupo_jornada', 45);
            $table->foreignId('grupo_cursoid');
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
        Schema::dropIfExists('colegio_grupos');
    }
};
