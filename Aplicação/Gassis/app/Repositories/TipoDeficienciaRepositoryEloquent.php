<?php

namespace App\Repositories;

use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use App\Repositories\TipoDeficienciaRepository;
use App\Entities\TipoDeficiencia;
use App\Validators\TipoDeficienciaValidator;

/**
 * Class TipoDeficienciaRepositoryEloquent.
 *
 * @package namespace App\Repositories;
 */
class TipoDeficienciaRepositoryEloquent extends BaseRepository implements TipoDeficienciaRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return TipoDeficiencia::class;
    }

    /**
    * Specify Validator class name
    *
    * @return mixed
    */
    public function validator()
    {

        return TipoDeficienciaValidator::class;
    }


    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }
    
}
