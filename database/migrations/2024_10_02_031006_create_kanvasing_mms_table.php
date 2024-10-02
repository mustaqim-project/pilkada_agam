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
        Schema::create('kanvasing_mms', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id');
            $table->string('kecamatan');
            $table->string('kelurahan');
            $table->string('no_kk');
            $table->string('no_ktp')->unique();
            $table->string('nama_responden');
            $table->date('tgl_lahir');
            $table->enum('jenis_kelamin', ['L', 'P'])->nullable();
            $table->foreignId('agama_id')->nullable();
            $table->foreignId('pekerjaan_id')->nullable();
            $table->text('alamat')->nullable();
            $table->string('foto_kegiatan')->nullable();
            $table->boolean('brosur')->nullable();
            $table->boolean('stiker')->nullable();
            $table->boolean('kartu_coblos')->nullable();
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
        Schema::dropIfExists('kanvasing_mms');
    }
};
