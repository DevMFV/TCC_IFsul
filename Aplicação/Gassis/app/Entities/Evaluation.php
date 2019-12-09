<?php

namespace App\Entities;

use Illuminate\Database\Eloquent\Model;
use Prettus\Repository\Contracts\Transformable;
use Prettus\Repository\Traits\TransformableTrait;
use App\Entities\Production;
use App\Entities\User;

/**
 * Class Evaluation.
 *
 * @package namespace App\Entities;
 */
class Evaluation extends Model implements Transformable
{
    use TransformableTrait;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'observacao',
        'filename',
        'atual',
        'production_id',
        'assisted_id',
    ];

    public function production(){
        return $this->belongsTo(Production::class, 'production_id');
    }

    public function assisted(){
        return $this->belongsTo(User::class, 'assisted_id');
    }

    public function anexos(){
        return $this->morphMany('\App\Entities\Attachment','owner');
    }

}
