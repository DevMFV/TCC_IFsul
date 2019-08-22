<?php

namespace App\Services;

Use App\Repositories\AdminRepository;
Use App\Validators\AdminValidator;
use Prettus\Validator\Contracts\ValidatorInterface;

class AdminService{

    private $validator;
    private $repository;


    public function __construct(AdminRepository $repository, AdminValidator $validator){

        $this->validator = $validator;
        $this->repository = $repository;
    }

    public function store($data){

        try{

            $this->validator->with($data)->passesOrFail(ValidatorInterface::RULE_CREATE);

            $admin = $this->repository->create($data);

            return[
                'success'=>true,
                'message'=>'Solicitante cadastrado',
                'data'=> $admin
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

    public function destroy($admin_id){
        try{
            $this->repository->delete($admin_id);

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