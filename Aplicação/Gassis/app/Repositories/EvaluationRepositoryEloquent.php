<?php

namespace App\Repositories;

use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use App\Repositories\EvaluationRepository;
use App\Entities\Evaluation;
use App\Validators\EvaluationValidator;

/**
 * Class EvaluationRepositoryEloquent.
 *
 * @package namespace App\Repositories;
 */
class EvaluationRepositoryEloquent extends BaseRepository implements EvaluationRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return Evaluation::class;
    }

    /**
    * Specify Validator class name
    *
    * @return mixed
    */
    public function validator()
    {

        return EvaluationValidator::class;
    }


    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }
    
}
