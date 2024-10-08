<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\anggaran;
use App\Models\periode;

class laporan_kegiatan extends Model
{
    use HasFactory;

    protected $table = 'laporan_kegiatan';
    protected $primaryKey = 'id';

    protected $fillable = [
        'anggaran_id',
        'periode_id',
        'deskripsi_kegiatan',
        'lampiran_kegiatan',
    ];

    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    public function anggaran()
    {
        return $this->belongsTo(anggaran::class, 'anggaran_id');
    }

    public function periode()
    {
        return $this->belongsTo(periode::class, 'periode_id');
    }
}
