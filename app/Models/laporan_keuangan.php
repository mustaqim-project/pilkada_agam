<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\anggaran;
use App\Models\periode;
use App\Models\jenis_pembiayaan;

class laporan_keuangan extends Model
{
    use HasFactory;

    protected $table = 'laporan_keuangan'; // Jika nama tabel tidak mengikuti konvensi plural Laravel
    protected $primaryKey = 'id';

    protected $fillable = [
        'anggaran_id',
        'periode_id',
        'jenis_pembiayaan_id',
        'jumlah_digunakan',
        'status',
        'bukti_pembayaran',
    ];

    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    // Relasi ke model Anggaran
    public function anggaran()
    {
        return $this->belongsTo(anggaran::class, 'anggaran_id');
    }

    // Relasi ke model Periode
    public function periode()
    {
        return $this->belongsTo(periode::class, 'periode_id');
    }

    // Relasi ke model JenisPembiayaan
    public function jenisPembiayaan()
    {
        return $this->belongsTo(jenis_pembiayaan::class, 'jenis_pembiayaan_id');
    }
}
