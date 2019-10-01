<?php

namespace App\Entities;

use Illuminate\Database\Eloquent\Model;
use Prettus\Repository\Contracts\Transformable;
use Prettus\Repository\Traits\TransformableTrait;

/**
 * Class Demand.
 *
 * @package namespace App\Entities;
 */
class Demand extends Model implements Transformable
{
    use TransformableTrait;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'titulo',
        'data_pedido',
        'data_prazo',
        'filename',
        'produzindo',
        'requester_id',
        'assisted_id',
        'descricao'
    ];

    public function requester(){
        return $this->belongsTo(User::class, 'requester_id');
    }

    public function assisted(){
        return $this->belongsTo(User::class, 'assisted_id');
    }



}
