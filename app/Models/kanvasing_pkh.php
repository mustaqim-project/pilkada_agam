<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Admin;
use App\Models\Kecematan;
use App\Models\Kelurahan;
use App\Models\pekerjaan;
class kanvasing_pkh extends Model
{
    use HasFactory;

    // Nama tabel di database
    protected $table = 'kanvasing_pkhs';

    // Atribut yang dapat diisi secara massal
    protected $fillable = [
        'user_id',
        'kecematan_id',
        'kelurahan_id',
        'no_ktp',
        'nama_responden',
        'tgl_lahir',
        'jenis_kelamin',
        'no_hp',
        'pekerjaan_id',
        'alamat',
        'foto_kegiatan',
        'jadwal',
        'hadir',
        'status',

    ];

    // Casting tipe data secara otomatis
    protected $casts = [
        'tgl_lahir' => 'date',
        'jadwal' => 'date',
        'hadir' => 'boolean',
        'status' => 'boolean',
    ];

    // Relasi belongsTo ke model User
    public function user()
    {
        return $this->belongsTo(Admin::class, 'user_id');
    }

    // Relasi belongsTo ke model Kecamatan
    public function kecematan()
    {
        return $this->belongsTo(Kecematan::class, 'kecematan_id'); // Ganti 'kecematan_id' dengan nama kolom yang sesuai
    }

    // Relasi ke model Pekerjaan
    public function pekerjaan()
    {
        return $this->belongsTo(Pekerjaan::class, 'pekerjaan_id'); // Ganti 'pekerjaan_id' dengan nama kolom yang sesuai
    }

    // Relasi belongsTo ke model Kelurahan
    public function kelurahan()
    {
        return $this->belongsTo(Kelurahan::class, 'kelurahan_id');
    }


}
