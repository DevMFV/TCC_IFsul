<?php

namespace App\Entities;

use Illuminate\Database\Eloquent\Model;
use Prettus\Repository\Contracts\Transformable;
use Prettus\Repository\Traits\TransformableTrait;

/**
 * Class TipoDeficiencia.
 *
 * @package namespace App\Entities;
 */
class TipoDeficiencia extends Model implements Transformable
{
    use TransformableTrait;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'tipo',
        'codigo'
    ];

    public $timestamps   =      true;

    public function users(){
        return $this->hasMany(User::class);
    }
}
