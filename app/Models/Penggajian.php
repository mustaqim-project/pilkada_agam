<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Penggajian extends Model
{
    use HasFactory;

    protected $table = 'penggajians';

    protected $fillable = [
        'employee_id',
        'tanggal_penggajian',
        'jumlah',
        'bukti_pembayaran',
    ];

    // Relasi dengan model Employee jika ada
    public function employee()
    {
        return $this->belongsTo(Employee::class);
    }
}
