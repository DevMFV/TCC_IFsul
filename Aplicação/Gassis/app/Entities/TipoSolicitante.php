<?php

namespace App\Entities;

use Illuminate\Database\Eloquent\Model;
use Prettus\Repository\Contracts\Transformable;
use Prettus\Repository\Traits\TransformableTrait;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class TipoSolicitante.
 *
 * @package namespace App\Entities;
 */
class TipoSolicitante extends Model implements Transformable
{
    use TransformableTrait;
    use SoftDeletes;

    protected $dates=['deleted_at'];

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable  =      ['tipo'];
    
    public $timestamps   =      true;

    public function users(){
        return $this->hasMany(User::class);
    }

}
