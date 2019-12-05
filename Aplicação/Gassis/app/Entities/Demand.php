<?php

namespace App\Entities;

use Illuminate\Database\Eloquent\Model;
use Prettus\Repository\Contracts\Transformable;
use Prettus\Repository\Traits\TransformableTrait;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Entities\Production;
use App\Entities\Designation;

/**
 * Class Demand.
 *
 * @package namespace App\Entities;
 */
class Demand extends Model implements Transformable
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
        'titulo',
        'data_pedido',
        'data_prazo',
        'filename',
        'produzindo',
        'requester_id',
        'assisted_id',
        'descricao',
        'urgencia'
        
    ];


    public function requester(){
        return $this->belongsTo(User::class, 'requester_id');
    }

    public function assisted(){
        return $this->belongsTo(User::class, 'assisted_id');
    }

    public function production(){
        return $this->hasMany(Production::class);
    }

    public function designation(){
        return $this->hasMany(Designation::class);
    }

    public function anexos(){
        return $this->morphMany('\App\Entities\Attachment','owner');
    }

}
