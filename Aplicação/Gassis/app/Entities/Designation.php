<?php

namespace App\Entities;

use Illuminate\Database\Eloquent\Model;
use Prettus\Repository\Contracts\Transformable;
use Prettus\Repository\Traits\TransformableTrait;
use App\Entities\Production;
use App\Entities\Demand;
use App\Entities\User;

/**
 * Class Designation.
 *
 * @package namespace App\Entities;
 */
class Designation extends Model implements Transformable
{
    use TransformableTrait;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'productor_id',
        'demand_id',
        'admin_id',

    ];

    public function production(){
        return $this->belongsTo(User::class, 'productor_id');
    }

    public function demand(){
        return $this->belongsTo(Demand::class, 'demand_id');
    }

    public function assisted(){
        return $this->belongsTo(User::class, 'admin_id');
    }

}
