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
        Schema::create('kanvasing_jjs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id');
            $table->string('provinsi', 100)->nullable();
            $table->string('kabupaten', 100)->nullable();
            $table->string('kecamatan', 100)->nullable();
            $table->string('kelurahan', 100)->nullable();
            $table->string('no_kk', 16)->nullable();
            $table->string('no_ktp', 16)->unique();
            $table->string('nama_responden', 100)->nullable();
            $table->date('tgl_lahir')->nullable();
            $table->enum('jenis_kelamin', ['L', 'P'])->nullable();
            $table->foreignId('agama_id')->nullable()->constrained()->nullOnDelete();
            $table->foreignId('pekerjaan_id')->nullable()->constrained()->nullOnDelete();
            $table->text('alamat')->nullable();
            $table->string('foto_kegiatan')->nullable();
            $table->boolean('brosur')->default(false);
            $table->boolean('stiker')->default(false);
            $table->boolean('kartu_coblos')->default(false);
            $table->string('longitude')->nullable();
            $table->string('latitude')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('kanvasing_jjs');
    }
};
