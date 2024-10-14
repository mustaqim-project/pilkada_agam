<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
Use App\Models\jenis_pembiayaan;
class DetailPembiayaan extends Model
{
    use HasFactory;

    // Nama tabel
    protected $table = 'detail_pembiayaan';

    // Kolom yang dapat diisi (mass assignable)
    protected $fillable = [
        'jenis_pembiayaan_id',
        'nama_rincian',
    ];

    // Kolom timestamps (created_at dan updated_at) secara default sudah diatur oleh Laravel, jadi tidak perlu diubah
    public $timestamps = true;

    // Jika kamu ingin menentukan format date secara khusus
    protected $dates = [
        'created_at',
        'updated_at',
    ];

    // Relasi ke tabel 'jenis_pembiayaan' (asumsi ada model dan tabel terkait)
    public function jenisPembiayaan()
    {
        return $this->belongsTo(jenis_pembiayaan::class, 'jenis_pembiayaan_id');
    }
}
