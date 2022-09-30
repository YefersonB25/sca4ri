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
        Schema::create('profesores_asignados', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('profe_cantidad');
            $table->string('profe_nombre', 256);
            $table->foreignId('profe_profeid');
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
        Schema::dropIfExists('profesores_asignados');
    }
};
