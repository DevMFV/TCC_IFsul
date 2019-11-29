<?php

namespace App\Repositories;

use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use App\Repositories\ProductionRepository;
use App\Entities\Production;
use App\Validators\ProductionValidator;

/**
 * Class ProductionRepositoryEloquent.
 *
 * @package namespace App\Repositories;
 */
class ProductionRepositoryEloquent extends BaseRepository implements ProductionRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return Production::class;
    }

    /**
    * Specify Validator class name
    *
    * @return mixed
    */
    public function validator()
    {

        return ProductionValidator::class;
    }


    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }
    
}
