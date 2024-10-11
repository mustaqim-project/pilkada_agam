<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Wilayah extends Model
{
    use HasFactory;

    // Nama tabel jika tidak sesuai dengan konvensi Laravel
    protected $table = 'wilayah';

    // Atribut yang dapat diisi secara massal
    protected $fillable = [
        'nama_wilayah',
    ];
}
