<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use App\Models\{  
    Patient,
    Doctor,
};
class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable, HasUuids;
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    public $incrementing = false; 
    public $keyType  = 'string';

     

    public static $roles = [
        1 => "messages.admin",
        2 => "messages.doctor",
        3 => "messages.pacient",
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
        'password' => 'hashed',
    ];

    public static function getRoles($role = null){
        if($role != null){
            return self::$roles[$role];
        }

        return self::$roles;
    }

    public function patient()
    {
        return $this->hasOne(Patient::class);
    }

    public function doctor()
    {
        return $this->hasOne(Doctor::class);
    }
}

