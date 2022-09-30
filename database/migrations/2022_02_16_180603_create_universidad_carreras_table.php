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
        Schema::create('universidad_carreras', function (Blueprint $table) {
            $table->increments('id');
            $table->string('carrera_codigo')->nullable();
            $table->string('carrera_nombre', 256);
            $table->foreignId('carrera_sedeid');
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
        Schema::dropIfExists('universidad_carreras');
    }
};
