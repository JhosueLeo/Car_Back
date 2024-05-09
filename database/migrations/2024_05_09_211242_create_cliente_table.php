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
        Schema::create('cliente', function (Blueprint $table) {
            $table->id();
            $table->foreignId('persona_id')->nullable()->references('id')->on('persona')->onUpdate('cascade')->onDelete('cascade');
            $table->foreignId('vehiculo_id')->nullable()->references('id')->on('vehiculo')->onUpdate('cascade')->onDelete('cascade');
            $table->char('estado_registro')->default('A');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('cliente');
    }
};
