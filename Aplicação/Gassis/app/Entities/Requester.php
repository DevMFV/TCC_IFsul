<?php

namespace App\Entities;

use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\SoftDeletes;

class Requester extends Authenticatable
{
    use Notifiable;
    use SoftDeletes;

    public $timestamps = true;

    /*name
    birth
    filename
    login
    password
    status
    permission
    */

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'birth', 'filename', 'email', 'password', 'status', 'permission'
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

    public function setPasswordAttribute($value){
        $this->attributes['password'] = env('PASSWORD_HASH') ? bcrypt($value) : $value;
    }

}
