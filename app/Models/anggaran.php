<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class anggaran extends Model
{
    use HasFactory;
    protected $table = 'anggaran';
    protected $primaryKey = 'id';
    protected $fillable = [
        'tim_id',
        'total_anggaran',
        'jumlah_periode',
    ];
    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];
    public function tim()
    {
        return $this->belongsTo(Tim::class, 'tim_id');
    }
}
