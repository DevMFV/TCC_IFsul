<?php

namespace App\Entities;

use Illuminate\Database\Eloquent\Model;
use Prettus\Repository\Contracts\Transformable;
use Prettus\Repository\Traits\TransformableTrait;
use App\Entities\Fase;
use App\Entities\User;
use App\Entities\Demand;
use App\Entities\CurrentState;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class Production.
 *
 * @package namespace App\Entities;
 */
class Production extends Model implements Transformable
{
    use TransformableTrait;
    use SoftDeletes;

    protected $dates=['deleted_at'];

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        "filename",
        "fase_id",
        "productor_id",
        "demand_id",
        "current_state_id",
        "avaliada",
        "descricao_suspensao",
        "designation_id"
    ];

    public function fase(){
        return $this->belongsTo(Fase::class, 'fase_id');
    }

    public function productor(){
        return $this->belongsTo(User::class, 'productor_id');
    }

    public function demand(){
        return $this->belongsTo(Demand::class, 'demand_id');
    }

    public function state(){
        return $this->belongsTo(CurrentState::class, 'current_state_id');
    }

}
