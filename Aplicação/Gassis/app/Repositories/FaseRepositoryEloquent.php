<?php

namespace App\Repositories;

use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use App\Repositories\FaseRepository;
use App\Entities\Fase;
use App\Validators\FaseValidator;

/**
 * Class FaseRepositoryEloquent.
 *
 * @package namespace App\Repositories;
 */
class FaseRepositoryEloquent extends BaseRepository implements FaseRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return Fase::class;
    }

    /**
    * Specify Validator class name
    *
    * @return mixed
    */
    public function validator()
    {

        return FaseValidator::class;
    }


    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }
    
}
