<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use App\Models\tim;
use App\Models\Admin;


class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    protected $table = "users"; // Specify the table name

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'pj_id', // This should relate to an Admin or equivalent model
        'tim_id', // This should relate to a Tim model
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed', // Ensure password is hashed
    ];

    /**
     * Relasi ke tabel Admins.
     */
    public function admin()
    {
        return $this->belongsTo(Admin::class, 'pj_id'); // Relationship to the admin (penanggung jawab)
    }

    /**
     * Relasi ke tabel Tim.
     */
    public function tim()
    {
        return $this->belongsTo(tim::class, 'tim_id'); // Relationship to the Tim
    }



}
