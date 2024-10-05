<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;
class spanduk_mm extends Model
{
    use HasFactory;

    protected $table = 'spanduk_mms';
    protected $primaryKey = 'id';
    protected $keyType = 'bigint';

    protected $fillable = [
        'user_id',
        'provinsi',
        'kabupaten',
        'kecamatan',
        'kelurahan',
        'alamat',
        'foto_kegiatan',
        'longitude',
        'latitude',
    ];

    public $timestamps = true;

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
