<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
Use App\Models\Periode;
Use App\Models\DetailPembiayaan;

class PenggunaanAnggaran extends Model
{
    use HasFactory;

    // Nama tabel
    protected $table = 'penggunaan_anggaran';

    // Kolom yang dapat diisi (mass assignable)
    protected $fillable = [
        'periode_id',
        'detail_pembiayaan_id',
        'jumlah_digunakan',
        'status_pembayaran',
        'bukti_pembayaran',
        'keterangan'
    ];

    // Kolom timestamps (created_at dan updated_at) secara default sudah diatur oleh Laravel
    public $timestamps = true;

    // Jika kamu ingin menentukan format date secara khusus
    protected $dates = [
        'created_at',
        'updated_at',
    ];

    // Relasi ke tabel 'periode' (asumsi ada model dan tabel terkait)
    public function periode()
    {
        return $this->belongsTo(Periode::class, 'periode_id');
    }

    // Relasi ke tabel 'detail_pembiayaan' (asumsi ada model dan tabel terkait)
    public function detailPembiayaan()
    {
        return $this->belongsTo(DetailPembiayaan::class, 'detail_pembiayaan_id');
    }
}
