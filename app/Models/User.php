<?php

namespace App\Models;

use App\Models\PB;
use App\Models\BarangKeluar;
use Spatie\Permission\Traits\HasRoles;
use Illuminate\Notifications\Notifiable;
use Spatie\Activitylog\Traits\LogsActivity;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use HasFactory, Notifiable, HasRoles, LogsActivity;

    protected static $logAttributes = [
        'name',
        'email'
    ];

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'username',
        'foto',
        'status'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function getFoto()
    {
        return $this->foto ? asset('/storage/user/' . $this->foto) : asset('/images/default/default.png');
    }

    public function pbs()
    {
        return $this->hasMany(PB::class, 'user_id', 'id');
    }

    public function usersPemberi()
    {
        return $this->hasMany(BarangKeluar::class, 'pemberi', 'id');
    }
    public function usersPenerima()
    {
        return $this->hasMany(BarangKeluar::class, 'penerima', 'id');
    }
}
