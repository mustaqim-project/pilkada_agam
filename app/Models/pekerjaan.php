<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class pekerjaan extends Model
{
    use HasFactory;

    protected $table = 'pekerjaans'; // Specify the table name if it's not following Laravel's pluralization
    protected $primaryKey = 'id'; // Define the primary key
    public $incrementing = false; // Set this to false if id is not auto-incrementing
    protected $keyType = 'bigint'; // Specify the key type if it's bigint

    protected $fillable = [
        'name', // Define fillable fields for mass assignment
    ];

    // Optional: Define timestamps behavior
    public $timestamps = true; // Automatically manage created_at and updated_at
}
