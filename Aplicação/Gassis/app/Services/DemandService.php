<?php

namespace App\Services;

Use App\Repositories\DemandRepository;
Use App\Validators\DemandValidator;
use Prettus\Validator\Contracts\ValidatorInterface;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use File;

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

    public function update($data, $id){

        try{

            $demand = $this->repository->find($id);

            $dataUse = $data;

            $dataUse += ["arquivo"=>null];

            if($dataUse["arquivo"]!=null){
                if($demand->filename!=null){
                    // DEVE EXCLUIR A IMAGEM ANTERIOR
                    $data["arquivo"]->storeAs('public/demands',$demand->id.'.'.$data["arquivo"]->extension());
                    $filename = "storage/demands".'/'.$demand->id.".".$data["arquivo"]->extension();
                }
            
                else{
                    $filename = $data;
                }
                $data += ["filename"=>$filename];
            }

            $this->validator->with($data)->passesOrFail(ValidatorInterface::RULE_UPDATE);

            $demand = $this->repository->update($data,$id);

            return[
                'success'=>true,
                'message'=>'Produção iniciada',
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