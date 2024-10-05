<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class tim extends Model
{
    use HasFactory;

    protected $table = 'tims'; // Specify the table name
    protected $primaryKey = 'id'; // Define the primary key
    public $incrementing = false; // Set this to false if id is not auto-incrementing
    protected $keyType = 'bigint'; // Specify the key type if it's bigint

    protected $fillable = [
        'name', // Fillable properties for mass assignment
        // You can add other relevant fields here
    ];

    public $timestamps = true; // Automatically manage created_at and updated_at

    // Relasi ke model User (misalnya)
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id'); // Define the belongsTo relationship with User
    }
}
