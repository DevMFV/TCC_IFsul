<?php

namespace App\Repositories;
use App\Repositories\DemandRepository;

class GenericFunctionsForRepository {

    /**
     * Specify Model class name
     *
     * @return array
     */
    public function findLastRegister($repository)
    {
            $all = $repository->all();
            foreach ($all as $key => $value) {$last = $value;}
        dd($last);    
    }

}