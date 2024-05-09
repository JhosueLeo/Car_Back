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
        Schema::create('producto', function (Blueprint $table) {
            $table->id();
            $table->string('nombre')->nullable();
            $table->string('marca')->nullable();
            $table->string('descripcion')->nullable();
            $table->string('precio')->nullable();
            $table->char('tipo')->nullable();
            $table->foreignId('categoria_id')->nullable()->references('id')->on('categoria')->onUpdate('cascade')->onDelete('cascade');
            $table->char('estado_registro')->default('A');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('producto');
    }
};
