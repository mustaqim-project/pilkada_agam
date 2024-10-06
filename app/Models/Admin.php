<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use App\Models\Report;
use App\Models\tim;
use App\Models\Jabatan;
use Laravel\Sanctum\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Admin extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;
    use HasRoles;

    protected $guard = 'admin';
    protected $table = 'admins';
    protected $primaryKey = 'id';
    protected $fillable = [
        'image',
        'name',
        'email',
        'atasan_id',
        'tim_id',
        'jabatan_id',
        'password',
        'status',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
        'status' => 'boolean',
    ];

    public function atasan()
    {
        return $this->belongsTo(Admin::class, 'atasan_id');
    }

    public function tim()
    {
        return $this->belongsTo(tim::class, 'tim_id');
    }

    public function jabatan()
    {
        return $this->belongsTo(Jabatan::class, 'jabatan_id');
    }

    public function reports()
    {
        return $this->hasMany(Report::class, 'created_by');
    }

    public function assignedReports()
    {
        return $this->hasMany(Report::class, 'assigned_to');
    }
}
