<?php

namespace App\Models;

use App\Models\User;
use App\Models\agamas;
use App\Models\pekerjaan;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class kanvasing_pkh extends Model
{
    use HasFactory;

    protected $table = 'kanvasing_pkhs';
    protected $primaryKey = 'id';
    public $incrementing = false;

    protected $fillable = [
        'user_id',
        'provinsi',
        'kabupaten',
        'kecamatan',
        'kelurahan',
        'no_kk',
        'no_ktp',
        'nama_responden',
        'tgl_lahir',
        'jenis_kelamin',
        'agama_id',
        'pekerjaan_id',
        'alamat',
        'foto_kegiatan',
        'brosur',
        'stiker',
        'kartu_coblos',
        'longitude',
        'latitude',
    ];

    protected $casts = [
        'tgl_lahir' => 'date',
        'brosur' => 'boolean',
        'stiker' => 'boolean',
        'kartu_coblos' => 'boolean',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    // Relasi ke model User
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    // Relasi ke model Agama
    public function agama()
    {
        return $this->belongsTo(agamas::class, 'agama_id');
    }

    // Relasi ke model Pekerjaan
    public function pekerjaan()
    {
        return $this->belongsTo(pekerjaan::class, 'pekerjaan_id');
    }
}
