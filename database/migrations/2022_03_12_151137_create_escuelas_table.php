<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('escuelas', function (Blueprint $table) {
            $table->id();
            $table->string('uuid', 40);
            $table->string('nombre', 50)->unique();
            $table->string('facultad_abrev', 7)->unique();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('escuelas');
    }
};
