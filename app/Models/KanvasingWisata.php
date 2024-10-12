<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Admin;
use App\Models\Kecematan;
use App\Models\Kelurahan;
use App\Models\pekerjaan;
class KanvasingWisata extends Model
{
    use HasFactory;

    // Nama tabel di database
    protected $table = 'kanvasing_wisata';

    // Atribut yang dapat diisi secara massal
    protected $fillable = [
        'user_id',
        'kecematan_id',
        'kelurahan_id',
        'no_kk',
        'no_ktp',
        'nama_responden',
        'tgl_lahir',
        'jenis_kelamin',
        'pekerjaan_id',
        'alamat',
        'foto_kegiatan',
        'brosur',
        'stiker',
        'kartu_coblos',
        'longitude',
        'latitude',
    ];

    // Casting tipe data secara otomatis
    protected $casts = [
        'tgl_lahir' => 'date',
        'brosur' => 'boolean',
        'stiker' => 'boolean',
        'kartu_coblos' => 'boolean',
    ];

    // Relasi belongsTo ke model User
    public function user()
    {
        return $this->belongsTo(Admin::class, 'user_id');
    }

    // Relasi belongsTo ke model Kecamatan
    public function kecamatan()
    {
        return $this->belongsTo(Kecematan::class, 'kecematan_id');
    }

    // Relasi belongsTo ke model Kelurahan
    public function kelurahan()
    {
        return $this->belongsTo(Kelurahan::class, 'kelurahan_id');
    }

    // Relasi belongsTo ke model Pekerjaan
    public function pekerjaan()
    {
        return $this->belongsTo(pekerjaan::class, 'pekerjaan_id');
    }
}
