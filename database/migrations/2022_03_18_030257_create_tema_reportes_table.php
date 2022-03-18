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
        Schema::create('tema_reportes', function (Blueprint $table) {
            $table->id();
            $table->foreignId('motivo_id')->constrained('motivos')
                ->cascadeOnUpdate()
                ->cascadeOnDelete();
            $table->foreignId('usuario_id')->constrained('usuarios')
                ->cascadeOnUpdate()
                ->cascadeOnDelete();
            $table->foreignId('proyecto_id')->constrained('proyectos')
                ->cascadeOnUpdate()
                ->cascadeOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tema_reportes');
    }
};
