<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;
class spanduk_jj extends Model
{
    use HasFactory;

    protected $table = 'spanduk_jjs'; // Specify the table name
    protected $primaryKey = 'id'; // Define the primary key
    protected $keyType = 'bigint'; // Specify the key type if it's bigint

    protected $fillable = [
        'user_id',         // Foreign key
        'provinsi',
        'kabupaten',
        'kecamatan',
        'kelurahan',
        'alamat',
        'foto_kegiatan',
        'longitude',
        'latitude',
    ];

    public $timestamps = true; // Automatically manage created_at and updated_at

    // Relasi ke model User
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id'); // Define the belongsTo relationship
    }
}
