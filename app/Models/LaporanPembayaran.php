<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\PenggunaanAnggaran;
class LaporanPembayaran extends Model
{
    use HasFactory;

    protected $table = 'laporan_pembayaran';

    protected $fillable = [
        'penggunaan_anggaran_id',
        'tujuan_pembayaran',
        'nominal',
        'bukti_pembayaran',
        'tanggal_pembayaran',
    ];

    public function penggunaanAnggaran()
    {
        return $this->belongsTo(PenggunaanAnggaran::class, 'penggunaan_anggaran_id');
    }
}
