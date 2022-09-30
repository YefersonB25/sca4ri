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
        Schema::create('universitarios_asignados', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('uni_asig_cantidad')->nullable();
            $table->string('uni_asig_nombre', 256);
            $table->json('uni_asig_universitariosid');
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
        Schema::dropIfExists('universitarios_asignados');
    }
};
