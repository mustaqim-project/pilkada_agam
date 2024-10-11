<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Gaji extends Model
{
    use HasFactory;
    protected $table = 'gaji';

    protected $fillable = [
        'admin_id', 'gaji', 'periode', 'bukti_pembayaran'
    ];

    public function admin()
    {
        return $this->belongsTo(Admin::class);
    }
}
