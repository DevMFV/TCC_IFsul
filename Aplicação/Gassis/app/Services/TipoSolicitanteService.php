<?php

namespace App\Services;

Use App\Repositories\TipoSolicitanteRepository;
Use App\Validators\TipoSolicitanteValidator;
use Prettus\Validator\Contracts\ValidatorInterface;

class TipoSolicitanteService{

    private $validator;
    private $repository;


    public function __construct(TipoSolicitanteRepository $repository, TipoSolicitanteValidator $validator){

        $this->validator = $validator;
        $this->repository = $repository;
    }

    public function store(array $data){

        try{

            $this->validator->with($data)->passesOrFail(ValidatorInterface::RULE_CREATE);

            $tipoSolicitante = $this->repository->create($data);

            return[
                'success'=>true,
                'message'=>'tipo cadastrado',
                'data'=> $tipoSolicitante
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

    public function destroy($tipoSolicitante_id){
        try{
            $this->repository->delete($tipoSolicitante_id);

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