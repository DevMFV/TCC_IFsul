<?php

namespace App\Entities;

use Illuminate\Database\Eloquent\Model;
use Prettus\Repository\Contracts\Transformable;
use Prettus\Repository\Traits\TransformableTrait;

/**
 * Class CurrentState.
 *
 * @package namespace App\Entities;
 */
class CurrentState extends Model implements Transformable
{
    use TransformableTrait;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [    
        'state',
        'codigo'
    ];

    public function production(){
        return $this->hasMany(Production::class);
    }
}
