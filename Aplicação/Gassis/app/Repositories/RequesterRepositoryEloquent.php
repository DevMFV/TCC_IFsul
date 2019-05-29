<?php

namespace App\Repositories;

use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use App\Repositories\RequesterRepository;
use App\Entities\Requester;
use App\Validators\RequesterValidator;

/**
 * Class RequesterRepositoryEloquent.
 *
 * @package namespace App\Repositories;
 */
class RequesterRepositoryEloquent extends BaseRepository implements RequesterRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return Requester::class;
    }

    /**
    * Specify Validator class name
    *
    * @return mixed
    */
    public function validator()
    {

        return RequesterValidator::class;
    }


    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }
    
}
