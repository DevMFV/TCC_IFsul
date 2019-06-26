<?php

namespace App\Services;

Use App\Repositories\RequesterRepository;
Use App\Validators\RequesterValidator;
use Prettus\Validator\Contracts\ValidatorInterface;

class REquesterService{

    private $validator;
    private $repository;


    public function __construct(RequesterRepository $repository, RequesterValidator $validator){

        $this->validator = $validator;
        $this->repository = $repository;
    }

    public function store($data){

        try{

            $this->validator->with($data)->passesOrFail(ValidatorInterface::RULE_CREATE);
            $requester = $this->repository->create($data);

            return[
                'success'=>true,
                'message'=>'Solicitante cadastrado',
                'data'=> $requester
            ];
        }
        catch(\Exeption $e){


            switch(get_class($e)){
                case QueryException::class          : return ['success' => false, 'message' =>$e->getMessage()];
                case ValidatorException::class      : return ['success' => false, 'message' =>$e->getMessageBag()];
                case QueryException::class          : return ['success' => false, 'message' =>$e->getMessage()];
                default                             : return ['success' => false, 'message' =>$e->getMessage()];
            }


            return[
                'success'=>false,
                'message'=>$e->getMessage(),
            ];
        }
    }

    public function update(){

    }

    public function delete(){

    }
   
}