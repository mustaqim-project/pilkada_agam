<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
Use App\Models\Kecematan;
class Kelurahan extends Model
{
    use HasFactory;

    protected $table = 'kelurahan';

    protected $fillable = [
        'nama_kelurahan',
        'kecamatan_id',
    ];

    // Relasi belongsTo ke model Kecamatan
    public function kecamatan()
    {
        return $this->belongsTo(Kecematan::class, 'kecamatan_id');
    }
}
