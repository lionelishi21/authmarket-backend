<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Laravel\Passport\HasApiTokens;
use Emadadly\LaravelUuid\Uuids;

use App\Notifications\VerifyApiEmail;

class User extends Authenticatable implements MustVerifyEmail
{
     use HasApiTokens, Notifiable, Uuids;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password','phone', 'role_id', 'address', 'city', 'district', 'username', 'company'
    ];


    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];


    public function sendApiEmailVerificationNotification(){
        $this->notify(new VerifyApiEmail); // my notification
    }
}
