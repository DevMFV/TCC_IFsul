<?php

namespace App\Repositories;

use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use App\Repositories\Current_stateRepository;
use App\Entities\CurrentState;
use App\Validators\CurrentStateValidator;

/**
 * Class CurrentStateRepositoryEloquent.
 *
 * @package namespace App\Repositories;
 */
class CurrentStateRepositoryEloquent extends BaseRepository implements CurrentStateRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return CurrentState::class;
    }

    /**
    * Specify Validator class name
    *
    * @return mixed
    */
    public function validator()
    {

        return CurrentStateValidator::class;
    }


    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }
    
}
