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
        Schema::create('detalle_tipo_servicio', function (Blueprint $table) {
            $table->id();
            $table->foreignId('servicio_id')->nullable()->references('id')->on('servicio')->onUpdte('cascade')->onDelete('cascade');
            $table->foreignId('tipo_servicio_id')->nullable()->references('id')->on('tipo_servicio')->onUpdate('cascade')->onDelete('cascade');
            $table->char('estado_registro')->default('A');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('detalle_tipo_servicio');
    }
};
