<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Kelurahan extends Model
{
    use HasFactory;

    // Nama tabel jika tidak sesuai dengan konvensi Laravel
    protected $table = 'kelurahan';

    // Atribut yang dapat diisi secara massal
    protected $fillable = [
        'nama_kelurahan',
        'kecamatan_id',
    ];

    // Relasi belongsTo ke model Kecamatan
    public function kecamatan()
    {
        return $this->belongsTo(Kecamatan::class, 'kecamatan_id');
    }
}
