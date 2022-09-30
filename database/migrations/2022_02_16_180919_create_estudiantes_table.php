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
        Schema::create('estudiantes', function (Blueprint $table) {
            $table->increments('id');
            $table->string('est_nombre_1', 256);
            $table->string('est_nombre_2', 256)->nullable();
            $table->string('est_apellido_1', 256);
            $table->string('est_apellido_2', 256)->nullable();
            $table->string('est_numerodoc', 45);
            $table->string('est_telefono', 45)->nullable();
            $table->string('est_direccion', 45) ->nullable();
            $table->string('est_tipodoc', 45);
            $table->foreignId('est_grupoid');
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
        Schema::dropIfExists('estudiantes');
    }
};
