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
        Schema::create('servicio_producto', function (Blueprint $table) {
            $table->id();
            $table->foreignId('servicio_id')->references('id')->on('servicio')->onUpdate('cascade')->onDelete('cascade');
            $table->foreignId('producto_id')->references('id')->on('producto')->onUpdate('cascade')->onDelete('cascade');
            $table->char('estado_registro')->default('A');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('servicio_producto');
    }
};
