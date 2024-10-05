<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class jabatan extends Model
{
    use HasFactory;

    protected $table = 'jabatans';

    protected $primaryKey = 'id';


    protected $fillable = [
        'name',
    ];

       protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];
}
