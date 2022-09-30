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
        Schema::create('colegio_sedes', function (Blueprint $table) {
            $table->increments('id');
            $table->string('sede_codigo');
            $table->string('sede_nombre', 256);
            $table->foreignId('sede_danecolegio');

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
        Schema::dropIfExists('colegio_sedes');
    }
};
