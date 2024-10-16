<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\tim;

class anggaran extends Model
{
    use HasFactory;
    protected $table = 'anggaran';
    protected $primaryKey = 'id';
    protected $fillable = [
        'tim_id',
        'total_anggaran',
    ];
    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];
    public function tim()
    {
        return $this->belongsTo(tim::class, 'tim_id');
    }
}
