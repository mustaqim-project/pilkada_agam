<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class jenis_pembiayaan extends Model
{
    use HasFactory;
    protected $table = 'jenis_pembiayaan';
    protected $primaryKey = 'id';

    protected $fillable = [
        'nama_pembiayaan',
    ];
    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];
}
