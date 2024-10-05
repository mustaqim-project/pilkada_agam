<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\anggaran;
class periode extends Model
{
    use HasFactory;

    protected $table = 'periode'; // Specify the table name
    protected $primaryKey = 'id'; // Define the primary key
    protected $keyType = 'bigint'; // Specify the key type if it's bigint

    protected $fillable = [
        'anggaran_id',      // Foreign key
        'nama_periode',
        'tanggal_mulai',
        'tanggal_selesai',
        'anggaran_periode',
    ];

    public $timestamps = true; // Automatically manage created_at and updated_at

    // Relasi ke model Anggaran
    public function anggaran()
    {
        return $this->belongsTo(anggaran::class, 'anggaran_id'); // Define the belongsTo relationship
    }
}
