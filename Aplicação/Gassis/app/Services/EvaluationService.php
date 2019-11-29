<?php

namespace App\Services;

Use App\Repositories\EvaluationRepository;
Use App\Validators\EvaluationValidator;
use Prettus\Validator\Contracts\ValidatorInterface;
use App\Entities\Evaluation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use File;

class EvaluationService{

    private $validator;
    private $repository;


    public function __construct(EvaluationRepository $repository, EvaluationValidator $validator){

        $this->validator = $validator;
        $this->repository = $repository;
    }

    // @param  UserCreateRequest $request

    public function store($data){

        try{

            $data += ["assisted_id"=>auth()->user()->id];

            $this->validator->with($data)->passesOrFail(ValidatorInterface::RULE_CREATE);

            $evaluation = $this->repository->create($data);

            return[
                'success'=>true,
                'message'=>'Demanda enviada',
                'data'=> $evaluation
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

            $evaluations = $this->repository->findwhere(['production_id'=>$productionId]);

            if($evaluations->all()!=null){

                foreach ($evaluations->all() as $key => $value) {
                    $last = $value;
                }
                
                $lastEvaluationId = $last["id"];

                $data = ['atual'=>false];
                    
                $this->validator->with($data)->passesOrFail(ValidatorInterface::RULE_UPDATE);
                
                $evaluation = $this->repository->update($data,$lastEvaluationId);
            }
            else{$evaluation=null;}

            return[
                'success'=>true,
                'message'=>'Produção iniciada',
                'data'=> $evaluation
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