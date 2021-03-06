<?php

namespace App\Entities;

use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Contracts\Auth\CanResetPassword;
use App\Entities\Production;
use App\Entities\Designation;

class User extends Authenticatable
{
    use Notifiable;
    use SoftDeletes;

    protected $dates=['deleted_at'];

    public $timestamps = true;

    /*name
    filename
    login
    password
    status
    */

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 
        'email',
        'permission', 
        'password', 
        'status',
        'tipo_deficiencia_id',
        'tipo_solicitante_id',
        'ocupado'

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

    public function tipoSol(){
        return $this->belongsTo(TipoSolicitante::class, 'tipo_solicitante_id');
    }

    public function tipoDef(){
        return $this->belongsTo(TipoDeficiencia::class, 'tipo_deficiencia_id');
    }

    public function productions(){
        return $this->hasMany(Production::class);
    }

    public function designation(){
        return $this->hasMany(Designation::class);
    }

}
