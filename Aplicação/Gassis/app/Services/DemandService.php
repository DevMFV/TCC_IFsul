<?php

namespace App\Services;

Use App\Repositories\DemandRepository;
Use App\Validators\DemandValidator;
use Prettus\Validator\Contracts\ValidatorInterface;
use Illuminate\Http\Request;

class DemandService{

    private $validator;
    private $repository;


    public function __construct(DemandRepository $repository, DemandValidator $validator){

        $this->validator = $validator;
        $this->repository = $repository;
    }

    // @param  UserCreateRequest $request

    public function store($data,$r){

        try{

            $data += ["requester_id"=>$r];

            $this->validator->with($data)->passesOrFail(ValidatorInterface::RULE_CREATE);

            $demand = $this->repository->create($data);

            return[
                'success'=>true,
                'message'=>'Demanda enviada',
                'data'=> $demand
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

    public function destroy($demand_id){
        try{
            $this->repository->delete($demand_id);

            return[
                'success'=>true,
                'message'=>'Usuário removido.'
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
   
}