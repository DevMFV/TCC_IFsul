<?php

namespace App\Services;

Use App\Repositories\EvaluationRepository;
Use App\Validators\EvaluationValidator;
use Prettus\Validator\Contracts\ValidatorInterface;
use App\Services\AttachmentService;
Use App\Repositories\AttachmentRepository;
Use App\Repositories\ProductionRepository;
Use App\Validators\ProductionValidator;
use App\Entities\Evaluation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use File;

class EvaluationService{

    private $validator;
    private $repository;
    private $attachmentService;
    private $attachmentRepository;
    private $productionRepository;
    private $productionValidator;


    public function __construct(EvaluationRepository $repository, EvaluationValidator $validator,
    AttachmentService $attachmentService,AttachmentRepository $attachmentRepository,
    ProductionRepository $productionRepository, ProductionValidator $productionValidator
    ){

        $this->validator = $validator;
        $this->repository = $repository;
        $this->attachmentService = $attachmentService;
        $this->attachmentRepository = $attachmentRepository;
        $this->productionRepository = $productionRepository;
        $this->productionValidator = $productionValidator;
    }

    // @param  UserCreateRequest $request

    public function store($data,$temArquivo){

        try{

            $all = Evaluation::all();

            if($all->all()!=[]){

                foreach ($all as $one) {$last = $one;}

                $evaluationOlderFiles = Evaluation::with('anexos')->where(['id'=>$last['id']])->first();

                $anexos = $evaluationOlderFiles['anexos']->all();

                foreach ($anexos as $anexo) {
                    if($anexo['atual']){
                        $this->attachmentRepository->update(["atual"=>false],$anexo["id"]);
                        
                    }
                }
            }

            $datas = [
                'assisted_id'=>auth()->user()->id,
                'observacao'=>$data['descricao'],
                'production_id'=>$data['production_id'],
                ];

            $this->validator->with($datas)->passesOrFail(ValidatorInterface::RULE_CREATE);

            $evaluation = $this->repository->create($datas);

            $all = Evaluation::all();

            foreach ($all as $one) {$last = $one;}

            $evaluationFile = $last;

            if($temArquivo){

                $files = $data['arquivo'];

                foreach ($files as $file) {

                    $filename = ["filename"=>"storage/demands".'/'.$evaluationFile['id']."-".time().".".$file->getClientOriginalExtension()];
                    $file->storeAs('public/demands',$evaluationFile['id']."-".time().".".$file->getClientOriginalExtension());
                    
                    $data = [
                        'name'=>$evaluationFile['id']."-".time().".".$file->getClientOriginalExtension(),
                        'original_name'=>$file->getClientOriginalName(),
                        'file'=>$filename['filename'],
                        'owner_id'=>$evaluationFile['id'],
                        'owner_type'=>'App\\Entities\\Evaluation',
                        'atual'=>true,
                    ];
                    
                    $request = $this->attachmentService->store($data);
                    
                }
            }
            
            $production_id = $last['production_id'];

            $dataP = ["current_state_id"=>3]; 

            $this->productionValidator->with($dataP)->passesOrFail(ValidatorInterface::RULE_UPDATE);

            $production = $this->productionRepository->update($dataP,$production_id);

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