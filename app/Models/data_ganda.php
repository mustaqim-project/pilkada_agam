<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class data_ganda extends Model
{
    use HasFactory;

    protected $table = 'data_gandas';

    protected $primaryKey = 'id';

    protected $fillable = [
        'kecamatan',
        'nagari',
        'no_ktp',
        'no_kk',
        'nama_responden',
        'alamat',
        'longitude',
        'latitude',
    ];



    public $timestamps = true;
}
