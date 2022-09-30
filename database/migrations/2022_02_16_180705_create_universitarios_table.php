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
        Schema::create('universitarios', function (Blueprint $table) {
            $table->increments('id');
            $table->string('uni_nombre_1', 256);
            $table->string('uni_nombre_2', 256)->nullable();
            $table->string('uni_apellido_1', 256);
            $table->string('uni_apellido_2', 256)->nullable();
            $table->string('uni_numerodoc', 45);
            $table->string('uni_telefono', 45)->nullable();
            $table->string('uni_direccion', 256)->nullable();
            $table->string('uni_tipodoc');
            $table->foreignId('uni_carreraid');
            $table->foreignId('uni_semestreid');
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
        Schema::dropIfExists('universitarios');
    }
};
