<?php

namespace App\Models;

use App\Models\User;
use App\Models\agamas;
use App\Models\pekerjaan;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class kanvasing_parpol extends Model
{
    use HasFactory;

    protected $table = 'kanvasing_parpols';
    protected $primaryKey = 'id';

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
        'brosur', // Menambahkan kolom baru
        'stiker', // Menambahkan kolom baru
        'kartu_coblos', // Menambahkan kolom baru
        'longitude', // Menambahkan kolom baru
        'latitude', // Menambahkan kolom baru
    ];

    // Casting tipe data secara otomatis
    protected $casts = [
        'tgl_lahir' => 'date',
        'jadwal' => 'date',
        'hadir' => 'boolean',
        'status' => 'boolean',
        'brosur' => 'boolean', // Menambahkan casting
        'stiker' => 'boolean', // Menambahkan casting
        'kartu_coblos' => 'boolean', // Menambahkan casting
    ];


    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function agama()
    {
        return $this->belongsTo(agamas::class, 'agama_id');
    }

    public function pekerjaan()
    {
        return $this->belongsTo(pekerjaan::class, 'pekerjaan_id');
    }
}
