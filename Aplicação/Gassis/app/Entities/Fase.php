<?php

namespace App\Entities;

use Illuminate\Database\Eloquent\Model;
use Prettus\Repository\Contracts\Transformable;
use Prettus\Repository\Traits\TransformableTrait;
use App\Entities\Production;

/**
 * Class Fase.
 *
 * @package namespace App\Entities;
 */
class Fase extends Model implements Transformable
{
    use TransformableTrait;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'fase',
        'codigo'
    ];

    public $timestamps   =      true;

    public function production(){
        return $this->hasMany(Production::class);
    }

}
