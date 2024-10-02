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
        Schema::create('data_gandas', function (Blueprint $table) {
            $table->id();
            $table->string('kecamatan');
            $table->string('nagari');
            $table->string('no_ktp');
            $table->string('no_kk')->nullable();
            $table->string('nama_responden');
            $table->string('foto_kegiatan')->nullable();
            $table->string('alamat')->nullable();
            $table->string('longitude');
            $table->string('latitude');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('data_gandas');
    }
};
