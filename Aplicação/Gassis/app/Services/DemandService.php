<?php

namespace App\Services;

use App\Repositories\UserRepository;
use App\Validators\UserValidator;
use App\Repositories\ProductionRepository;
use App\Validators\ProductionValidator;
Use App\Repositories\DemandRepository;
Use App\Validators\DemandValidator;
use Prettus\Validator\Contracts\ValidatorInterface;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use File;

class DemandService{

    private $validator;
    private $productionValidator;
    private $userValidator;
    private $repository;
    private $userRepository;
    private $productionRepository;


    public function __construct(DemandRepository $repository, DemandValidator $validator, 
    ProductionRepository $productionRepository, ProductionValidator $productionValidator,
    UserRepository $userRepository, UserValidator $userValidator){

        $this->validator = $validator;
        $this->repository = $repository;
        $this->productionValidator = $productionValidator;
        $this->productionRepository = $productionRepository;
        $this->userValidator = $userValidator;
        $this->userRepository = $userRepository;
    }

    // @param  UserCreateRequest $request

    public function store($data,$r){

        try{

            $data += ["requester_id"=>$r];

            if( date("m", strtotime($data['data_prazo'])) == date("m") ){

            //dd("mesmo mês",date("d", strtotime($data['data_prazo'])),date("d"));

                $diferença = date("d", strtotime($data['data_prazo'])) - date("d");

                if($diferença<=6){
                    $data += ["urgencia"=>"Alta"];
                }

                else if($diferença>6 && $diferença<=12){
                    $data += ["urgencia"=>"Média"];
                }

                else{
                    $data += ["urgencia"=>"Baixa"];
                }

            }

            else{

                //dd("mesmo mês");

                $data += ["urgencia"=>"Baixa"];

            }

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

    public function startProduction($id){

        try{

            $demand = $this->repository->find($id);

            $data = ["produzindo"=>true];

            $this->validator->with($data)->passesOrFail(ValidatorInterface::RULE_UPDATE);

            $demand = $this->repository->update($data,$id);

            $userDatas = ["ocupado"=>true];

            $this->userValidator->with($userDatas)->passesOrFail(ValidatorInterface::RULE_UPDATE);

            $user = $this->userRepository->update($userDatas,auth()->user()->id);

            $productionDatas = ['current_state_id'=>2,'fase_id'=>1,'productor_id'=>auth()->user()->id,'demand_id'=>$id];

            $this->productionValidator->with($productionDatas)->passesOrFail(ValidatorInterface::RULE_CREATE);

            $production = $this->productionRepository->create($productionDatas);

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