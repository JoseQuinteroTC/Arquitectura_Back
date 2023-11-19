<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        //
        Schema::create('productos', function (Blueprint $table) {
            $table->id('id');
            $table->foreign('idUsuario');
            $table->string('nombre');
            $table->integer('cantidad');
            $table->string('categoria');
            $table->string('unidad_de_medida');
            $table->string('descripcion');
            $table->integer('precio');


        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
    }
};
