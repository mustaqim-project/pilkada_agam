<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
Use App\Models\tim;
Use App\Models\jabatan;
Use App\Models\Bank;

class Employee extends Model
{
    use HasFactory;

    protected $fillable = [
        'tim_id',
        'jabatan_id',
        'nama',
        'gaji',
        'bank_id',
        'no_rekening',
        'tanggal_masuk'
    ];

    // Relationships (optional)
    public function tim()
    {
        return $this->belongsTo(tim::class);
    }

    public function jabatan()
    {
        return $this->belongsTo(jabatan::class);
    }

    public function bank()
    {
        return $this->belongsTo(Bank::class);
    }
}
