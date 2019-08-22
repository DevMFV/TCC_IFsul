<?php

namespace App\Repositories;

use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use App\Repositories\tipoSolicitanteRepository;
use App\Entities\TipoSolicitante;
use App\Validators\TipoSolicitanteValidator;

/**
 * Class TipoSolicitanteRepositoryEloquent.
 *
 * @package namespace App\Repositories;
 */
class TipoSolicitanteRepositoryEloquent extends BaseRepository implements TipoSolicitanteRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return TipoSolicitante::class;
    }

    /**
    * Specify Validator class name
    *
    * @return mixed
    */
    public function validator()
    {

        return TipoSolicitanteValidator::class;
    }


    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }
    
}
