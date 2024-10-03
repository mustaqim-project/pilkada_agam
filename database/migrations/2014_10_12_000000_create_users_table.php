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
        Schema::dropIfExists('users');
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->foreignId('pj_id')->constrained('admins'); // Mengambil dari admin id
            $table->string('name');
            $table->string('email')->unique();
            $table->string('password');
            $table->enum('tim', ['DS', 'PKH', 'MM', 'Asyiah', 'Parpol', 'JJ'])->nullable();
            $table->timestamps();
        });

    }
};
