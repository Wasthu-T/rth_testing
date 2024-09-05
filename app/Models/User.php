<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;

use App\Models\Traits\HasUuid;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Contracts\Auth\MustVerifyEmail;

class User extends Authenticatable implements MustVerifyEmail
{
    use HasApiTokens, HasFactory, Notifiable, HasUuid;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'username',
        'nm_lengkap',
        'alamat',
        'email',
        'no_hp',
        'password',

    ];
    protected $primaryKey = 'uuid';
    protected $guarded = ['admin'];
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
        'verif_hp_at' => 'datetime',
        'password' => 'hashed',
    ];


    public function ktps() {
        return $this->hasMany(klhn::class,'uuid','uuid');
    }
    public function otps()
    {
        return $this->hasMany(otp::class, 'uuid', 'uuid');
    }
    protected static function boot()
    {
        parent::boot();
        static::creating(function ($user) {
            if (empty($user->uuid)) {
                $user->uuid = static::bootHasUuid();
            }
        });
        
    }
    
}
