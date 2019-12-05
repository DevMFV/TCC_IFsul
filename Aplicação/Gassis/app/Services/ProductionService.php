<?php

namespace App\Services;

Use App\Repositories\UserRepository;
Use App\Validators\UserValidator;
Use App\Repositories\DemandRepository;
Use App\Validators\DemandValidator;
Use App\Repositories\ProductionRepository;
Use App\Validators\ProductionValidator;
use Prettus\Validator\Contracts\ValidatorInterface;
use App\Entities\Production;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use File;

class ProductionService{

    private $validator;
    private $repository;
    private $demandValidator;
    private $demandRepository;
    private $userValidator;
    private $userRepository;



    public function __construct(ProductionRepository $repository, ProductionValidator $validator,
    DemandRepository $demandRepository, DemandValidator $demandValidator,
    UserRepository $userRepository, UserValidator $userValidator){

        $this->validator = $validator;
        $this->repository = $repository;
        $this->demandValidator = $demandValidator;
        $this->demandRepository = $demandRepository;
        $this->userValidator = $userValidator;
        $this->userRepository = $userRepository;

    }

    // @param  UserCreateRequest $request


    public function update($id, $function, $descricao){

        try{

            switch ($function) {

                case 1:

                    $production = Production::find($id);

                    if($production['fase_id']!= 3){
                        $data = ["current_state_id"=>1];
                    }
                    else{
                        $data = ["current_state_id"=>null];
                    }

                    $this->validator->with($data)->passesOrFail(ValidatorInterface::RULE_UPDATE);
                
                    $production = $this->repository->update($data,$id);

                    $productions = $this->repository->findwhere(['productor_id'=>auth()->user()->id]);

                    foreach ($productions->all() as $key => $value) {

                        if($value['current_state_id']!=1){

                            $user_id = $this->repository->find($id)['productor_id'];

                            $userData = ["ocupado"=>true];

                            $this->userValidator->with($userData)->passesOrFail(ValidatorInterface::RULE_UPDATE);

                            $this->userRepository->update($userData,$user_id);

                        }
                        else{

                            $user_id = $this->repository->find($id)['productor_id'];

                            $userData = ["ocupado"=>false];

                            $this->userValidator->with($userData)->passesOrFail(ValidatorInterface::RULE_UPDATE);

                            $this->userRepository->update($userData,$user_id);

                        }

                    }

                    break;

                case 2:

                    $data = ["current_state_id"=>2,"descricao_suspensao"=>$descricao];

                    $this->validator->with($data)->passesOrFail(ValidatorInterface::RULE_UPDATE);

                    $production = $this->repository->update($data,$id);
                    break;

                case 3:

                    $user_id = $this->repository->find($id)['productor_id'];

                    $userData = ["ocupado"=>true];
        
                    $this->userValidator->with($userData)->passesOrFail(ValidatorInterface::RULE_UPDATE);

                    $this->userRepository->update($userData,$user_id);

                    $data = ["current_state_id"=>null]; 

                    $this->validator->with($data)->passesOrFail(ValidatorInterface::RULE_UPDATE);

                    $production = $this->repository->update($data,$id);
                    break;

                case 'avançar':

                    $production = Production::find($id);

                    $data = ["fase_id"=>$production['fase_id']+1];

                    $production = $this->repository->update($data,$id);
                    break;
                
                case 'finalizar':

                    $production = Production::find($id);

                    $data = ["fase_id"=>5];

                    $production = $this->repository->update($data,$id);
                    break;

                case 'avaliar':

                    $production = Production::find($id);

                    $data = ["fase_id"=>$production['fase_id']+1];

                    $production = $this->repository->update($data,$id);
                    break;

                case 'avaliada':

                    $production = Production::find($id);

                    $data = ["avaliada"=>true];
                    
                    $this->validator->with($data)->passesOrFail(ValidatorInterface::RULE_UPDATE);
                
                    $production = $this->repository->update($data,$id);

                    break;

                case 'adaptar':

                    $production = Production::find($id);

                    $data = ["fase_id"=>$production['fase_id']+1,"avaliada"=>false];

                    $production = $this->repository->update($data,$id);
                    break;

                case 'adaptada':

                    $production = Production::find($id);

                    $data = ["fase_id"=>$production['fase_id']-1];
                    
                    $this->validator->with($data)->passesOrFail(ValidatorInterface::RULE_UPDATE);
                
                    $production = $this->repository->update($data,$id);

                    break;
                    
            }

            return[
                'success'=>true,
                'message'=>'Produção iniciada',
                'data'=> $production
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

    public function destroy($production_id){
        try{

            $demand_id = $this->repository->find($production_id)['demand_id'];

            $demandData = ["produzindo"=>false];
            
            $this->demandValidator->with($demandData)->passesOrFail(ValidatorInterface::RULE_UPDATE);

            $this->demandRepository->update($demandData,$demand_id);

            $user_id = $this->repository->find($production_id)['productor_id'];

            $userData = ["ocupado"=>false];
            
            $this->userValidator->with($userData)->passesOrFail(ValidatorInterface::RULE_UPDATE);

            $this->userRepository->update($userData,$user_id);

            $this->repository->delete($production_id);

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