<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use App\Models\tim;
use App\Models\Admin;
use App\Models\Bank;


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
        'no_hp',
        'gaji',
        'kode_bank',
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

    public function bank()
    {
        return $this->belongsTo(Bank::class, 'kode_bank', 'kode_bank');
    }

}
