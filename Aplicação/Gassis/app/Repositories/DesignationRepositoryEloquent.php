<?php

namespace App\Repositories;

use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use App\Repositories\DesignationRepository;
use App\Entities\Designation;
use App\Validators\DesignationValidator;

/**
 * Class DesignationRepositoryEloquent.
 *
 * @package namespace App\Repositories;
 */
class DesignationRepositoryEloquent extends BaseRepository implements DesignationRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return Designation::class;
    }

    /**
    * Specify Validator class name
    *
    * @return mixed
    */
    public function validator()
    {

        return DesignationValidator::class;
    }


    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }
    
}
