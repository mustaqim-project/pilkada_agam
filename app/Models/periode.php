<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class periode extends Model
{
    use HasFactory;

    protected $table = 'periode';
    protected $primaryKey = 'id';

    protected $fillable = [
        'anggaran_id',
        'nama_periode',
        'tanggal_mulai',
        'tanggal_selesai',
        'anggaran_periode',
    ];

    public $timestamps = true;

    public function anggaran()
    {
        return $this->belongsTo(anggaran::class, 'anggaran_id');
    }
}
