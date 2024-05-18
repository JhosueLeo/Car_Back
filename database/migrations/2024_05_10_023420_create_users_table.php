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
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->foreignId('empleado_id')->nullable()->references('id')->on('empleado')->onDelete('cascade')->onUpdate('cascade');
            $table->string('username')->unique();
            $table->string('email_verified_at')->nullable();
            $table->string('password');
            $table->char('estado_registro')->default('A');
            $table->rememberToken();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};
