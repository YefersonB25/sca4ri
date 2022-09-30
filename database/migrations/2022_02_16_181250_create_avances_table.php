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
        Schema::create('avances', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('av_estado');
            $table->string('av_porcentaje', 256);
            $table->foreignId('av_semilleroid');
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
        Schema::dropIfExists('avances');
    }
};
