<?php

namespace App\Services;

Use App\Repositories\DesignationRepository;
Use App\Validators\DesignationValidator;
use Prettus\Validator\Contracts\ValidatorInterface;
use App\Entities\Designation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Repositories\DemandRepository;
use App\Validators\DemandValidator;
use App\Repositories\UserRepository;
use App\Validators\UserValidator;
use App\Validators\ProductionValidator;
use App\Repositories\ProductionRepository;

class DesignationService{

    private $validator;
    private $repository;
    private $demandRepository;
    private $demandValidator;
    private $userRepository;
    private $userValidator;
    private $productionRepository;
    private $productionValidator;


    public function __construct(
        DesignationRepository $repository, DesignationValidator $validator,
        DemandRepository $demandRepository,DemandValidator $demandValidator,
        UserRepository $userRepository,UserValidator $userValidator,
        ProductionRepository $productionRepository,ProductionValidator $productionValidator){

        $this->validator = $validator;
        $this->repository = $repository;
        $this->demandValidator = $demandValidator;
        $this->demandRepository = $demandRepository;
        $this->userValidator = $userValidator;
        $this->userRepository = $userRepository;
        $this->productionValidator = $productionValidator;
        $this->productionRepository = $productionRepository;

    }

    // @param  UserCreateRequest $request

    public function store($data){

        try{

            $data += ["assisted_id"=>auth()->user()->id];

            $this->validator->with($data)->passesOrFail(ValidatorInterface::RULE_CREATE);

            $designation = $this->repository->create($data);

            return[
                'success'=>true,
                'message'=>'Demanda enviada',
                'data'=> $designation
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


    public function update($productionId){

        try{

            $designations = $this->repository->findwhere(['production_id'=>$productionId]);

            if($designations->all()!=null){

                foreach ($designations->all() as $key => $value) {
                    $last = $value;
                }
                
                $lastDesignationId = $last["id"];

                $data = ['atual'=>false];
                    
                $this->validator->with($data)->passesOrFail(ValidatorInterface::RULE_UPDATE);
                
                $designation = $this->repository->update($data,$lastDesignationId);
            }
            else{$designation=null;}

            return[
                'success'=>true,
                'message'=>'Produção iniciada',
                'data'=> $designation
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

    public function destroy($designation_id){
        try{
            $this->repository->delete($designation_id);

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

    public function designate($productorId,$demandId){

        try{

            $demandData = ["produzindo"=>true];

            $this->validator->with($demandData)->passesOrFail(ValidatorInterface::RULE_UPDATE);

            $demand = $this->demandRepository->update($demandData,$demandId);

            $userData = ["ocupado"=>true];

            $this->validator->with($userData)->passesOrFail(ValidatorInterface::RULE_UPDATE);

            $user = $this->userRepository->update($userData,$productorId);

            // criar designação ======================================================================================

            $designationDatas = ['productor_id'=>$productorId,'demand_id'=>$demandId,'admin_id'=>auth()->user()->id];

            $this->validator->with($designationDatas)->passesOrFail(ValidatorInterface::RULE_CREATE);

            $designation = $this->repository->create($designationDatas);

            //======================================================================================================

            
            // criar produção ======================================================================================

            foreach ($this->repository->all() as $key => $value) {
                $last = $value;
            }

            $productionDatas = ['fase_id'=>1,'productor_id'=>$productorId,'demand_id'=>$demandId,'designation_id'=>$last['id']];

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