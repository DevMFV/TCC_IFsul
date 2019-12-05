<?php

namespace App\Services;

Use App\Repositories\AttachmentRepository;
Use App\Validators\AttachmentValidator;
use Prettus\Validator\Contracts\ValidatorInterface;

class AttachmentService{

    private $validator;
    private $repository;


    public function __construct(AttachmentRepository $repository, AttachmentValidator $validator){

        $this->validator = $validator;
        $this->repository = $repository;
    }

    public function store(array $data){

        try{

            $this->validator->with($data)->passesOrFail(ValidatorInterface::RULE_CREATE);

            $attachment = $this->repository->create($data);

            return[
                'success'=>true,
                'message'=>'tipo cadastrado',
                'data'=> $attachment
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

    public function destroy($attachment_id){
        try{
            $this->repository->delete($attachment_id);

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