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

    protected $table = "users";


    protected $fillable = [
        'name',
        'email',
        'password',
        'pj_id',
        'tim_id',
    ];


    protected $hidden = [
        'password',
        'remember_token',
    ];


    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];


    public function admin()
    {
        return $this->belongsTo(Admin::class, 'pj_id');
    }


    public function tim()
    {
        return $this->belongsTo(tim::class, 'tim_id');
    }



}
