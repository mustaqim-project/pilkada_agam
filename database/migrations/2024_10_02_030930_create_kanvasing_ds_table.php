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
        Schema::create('kanvasing_ds', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->string('provinsi', 100);  // Menambahkan kolom provinsi
            $table->string('kabupaten', 100); // Menambahkan kolom kabupaten
            $table->string('kecamatan', 100);
            $table->string('kelurahan', 100);
            $table->string('no_kk', 16);
            $table->string('no_ktp', 16)->unique();
            $table->string('nama_responden', 100);
            $table->date('tgl_lahir');
            $table->enum('jenis_kelamin', ['L', 'P'])->nullable();
            $table->foreignId('agama_id')->nullable()->constrained()->onDelete('set null');
            $table->foreignId('pekerjaan_id')->nullable()->constrained()->onDelete('set null');
            $table->text('alamat')->nullable();
            $table->string('foto_kegiatan')->nullable();
            $table->boolean('brosur')->default(false);
            $table->boolean('stiker')->default(false);
            $table->boolean('kartu_coblos')->default(false);
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
        Schema::dropIfExists('kanvasing_ds');
    }
};
