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
        Schema::create('universidad_semestres', function (Blueprint $table) {
            $table->increments('id');
            $table->string('semestre_codigo')->nullable();
            $table->string('semestre_nombre', 256);
            $table->foreignId('semestre_carreraid');
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
        Schema::dropIfExists('universidad_semestres');
    }
};
