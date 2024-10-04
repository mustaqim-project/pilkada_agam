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
        Schema::create('laporan_keuangan', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('anggaran_id');
            $table->unsignedBigInteger('periode_id');
            $table->unsignedBigInteger('jenis_pembiayaan_id');
            $table->decimal('jumlah_digunakan', 15, 2);
            $table->enum('status', ['unpaid', 'paid']);
            $table->string('bukti_pembayaran')->nullable();
            $table->timestamps();

            $table->foreign('anggaran_id')->references('id')->on('anggaran');
            $table->foreign('periode_id')->references('id')->on('periode');
            $table->foreign('jenis_pembiayaan_id')->references('id')->on('jenis_pembiayaan');
        });

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('laporan_keuangans');
    }
};
