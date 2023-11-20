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

        Schema::create('pedidos', function (Blueprint $table) {
            $table->id('id');
            $table->unsignedBigInteger('user_id'); // Clave foránea
            $table->unsignedBigInteger('producto_id'); // Clave foránea
            $table->foreign('user_id')->references('id')->on('users');
            $table->foreign('producto_id')->references('id')->on('productos');
            $table->integer('cantidad');
            $table->integer('precio');
            $table->boolean('carrito');
            $table->timestamps();
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
