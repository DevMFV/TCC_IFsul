<?php

namespace App\Services;

Use App\Repositories\UserRepository;
Use App\Validators\UserValidator;
Use App\Repositories\DemandRepository;
Use App\Validators\DemandValidator;
Use App\Repositories\ProductionRepository;
Use App\Repositories\AttachmentRepository;
Use App\Validators\ProductionValidator;
use Prettus\Validator\Contracts\ValidatorInterface;
use App\Services\AttachmentService;
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
    protected $attachmentRepository;
    protected $attachmentService;



    public function __construct(ProductionRepository $repository, ProductionValidator $validator,
    DemandRepository $demandRepository, DemandValidator $demandValidator,
    UserRepository $userRepository, UserValidator $userValidator,
    AttachmentRepository $attachmentRepository,AttachmentService $attachmentService){

        $this->validator = $validator;
        $this->repository = $repository;
        $this->demandValidator = $demandValidator;
        $this->demandRepository = $demandRepository;
        $this->userRepository = $userRepository;
        $this->userValidator = $userValidator;
        $this->attachmentRepository = $attachmentRepository;
        $this->attachmentService = $attachmentService;

    }

    // @param  UserCreateRequest $request


    public function update($id, $function, $descricao, $requestPar){

        try{

            switch ($function) {

                case 1:

                    $production = Production::find($id);

                    if($production['fase_id']!= 3){
                        $data = ["current_state_id"=>3];
                    }
                    else{
                        $data = ["current_state_id"=>2];
                    }

                    $this->validator->with($data)->passesOrFail(ValidatorInterface::RULE_UPDATE);
                
                    $production = $this->repository->update($data,$id);

                    $productions = $this->repository->findwhere(['productor_id'=>auth()->user()->id]);

                    foreach ($productions->all() as $key => $value) {

                        if($value['current_state_id']==3){

                            $user_id = $this->repository->find($id)['productor_id'];

                            $userData = ["ocupado"=>false];

                            $this->userValidator->with($userData)->passesOrFail(ValidatorInterface::RULE_UPDATE);

                            $this->userRepository->update($userData,$user_id);

                        }
                        else{

                            $user_id = $this->repository->find($id)['productor_id'];

                            $userData = ["ocupado"=>true];

                            $this->userValidator->with($userData)->passesOrFail(ValidatorInterface::RULE_UPDATE);

                            $this->userRepository->update($userData,$user_id);

                        }

                    }

                    break;

                case 2:

                        $productionContext = Production::find($id);

                        $productionAll = $this->repository->all();

                        foreach ($productionAll->all() as $key => $value) {


                            if($value['current_state_id']==3 || $value['current_state_id']==4 || $productionContext['fase_id']==2){
    
                                $ocupado = false;
        
                            }
                            else{
        
                                $ocupado = true;
        
                            }
    
                        }

                        $user_id = $productionContext['productor_id'];

                        $userData = ["ocupado"=>$ocupado];

                        $this->userValidator->with($userData)->passesOrFail(ValidatorInterface::RULE_UPDATE);

                        $user = $this->userRepository->update($userData,$user_id);

                    $data = ["current_state_id"=>4,"descricao_suspensao"=>$descricao];

                    $this->validator->with($data)->passesOrFail(ValidatorInterface::RULE_UPDATE);

                    $production = $this->repository->update($data,$id);

                    break;

                case 3:

                    $user_id = $this->repository->find($id)['productor_id'];

                    $userData = ["ocupado"=>true];
        
                    $this->userValidator->with($userData)->passesOrFail(ValidatorInterface::RULE_UPDATE);

                    $this->userRepository->update($userData,$user_id);

                    $data = ["current_state_id"=>2]; 

                    $this->validator->with($data)->passesOrFail(ValidatorInterface::RULE_UPDATE);

                    $production = $this->repository->update($data,$id);
                    break;

                case 'avançar':

                    $productionOlderFiles = Production::with('anexos')->where(['id'=>$id])->first();

                    $anexos = $productionOlderFiles['anexos']->all();

                    foreach ($anexos as $anexo) {
                        if($anexo['atual']){
                            $this->attachmentRepository->update(["atual"=>false],$anexo["id"]);
                        }
                    }
        
                    $productionStage = Production::find($id);

                    $data = ["fase_id"=>$productionStage['fase_id']+1];

                    $production = $this->repository->update($data,$id);

                    $productionAll = $this->repository->all();

                    if($productionStage['fase_id']==2 || $productionStage['fase_id']==3){

                        foreach ($productionAll->all() as $key => $value) {

                            if($value['current_state_id']==1 || $value['current_state_id']==2 || $productionStage['fase_id']==2){
    
                                $ocupado = false;
        
                            }
                            else{
        
                                $ocupado = true;
        
                            }
    
                        }

                        $user_id = $productionStage['productor_id'];

                        $userData = ["ocupado"=>$ocupado];

                        $this->userValidator->with($userData)->passesOrFail(ValidatorInterface::RULE_UPDATE);

                        $user = $this->userRepository->update($userData,$user_id);

                    }


                    $productionFile = $this->repository->find($id);

                    $files = $requestPar->file('arquivo');

                    if(!empty($requestPar->file('arquivo'))){
                        foreach ($files as $file) {
        
                            $filename = ["filename"=>"storage/demands".'/'.$productionFile['id']."-".time().".".$file->getClientOriginalExtension()];
                            $file->storeAs('public/demands',$productionFile['id']."-".time().".".$file->getClientOriginalExtension());
                            
                            $data = [
                                'name'=>$productionFile['id']."-".time().".".$file->getClientOriginalExtension(),
                                'original_name'=>$file->getClientOriginalName(),
                                'file'=>$filename['filename'],
                                'owner_id'=>$productionFile['id'],
                                'owner_type'=>'App\\Entities\\Production',
                                'atual'=>true,
                            ];
                            
                            $request = $this->attachmentService->store($data);

                        }
                    }
                    
                    break;
                
                case 'finalizar':

                    $user_id = $this->repository->find($id)['productor_id'];
                    
                    $userData = ["ocupado"=>false];
                    
                    $this->userValidator->with($userData)->passesOrFail(ValidatorInterface::RULE_UPDATE);
                    
                    $this->userRepository->update($userData,$user_id);

                    $production = Production::find($id);

                    $demand_id = $production['demand_id'];

                    $data = ["fase_id"=>5];

                    $production = $this->repository->update($data,$id);

                    $dataDemand = ["finalizada"=>true];

                    $this->demandValidator->with($dataDemand)->passesOrFail(ValidatorInterface::RULE_UPDATE);

                    $demand = $this->demandRepository->update($dataDemand,$demand_id);

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

                    $productionOlderFiles = Production::with('anexos')->where(['id'=>$id])->first();

                    $anexos = $productionOlderFiles['anexos']->all();

                    foreach ($anexos as $anexo) {
                        if($anexo['atual']){
                            $this->attachmentRepository->update(["atual"=>false],$anexo["id"]);
                        }
                    }

                    $productionStage = Production::find($id);

                    $productionAll = $this->repository->all();

                    if($productionStage['fase_id']==4 || $productionStage['fase_id']==3){

                        foreach ($productionAll->all() as $key => $value) {

                            if($value['current_state_id']==1 || $value['current_state_id']==2 || $productionStage['fase_id']==2){
    
                                $ocupado = false;
        
                            }
                            else{
        
                                $ocupado = true;
        
                            }
    
                        }

                        $user_id = $productionStage['productor_id'];

                        $userData = ["ocupado"=>$ocupado];

                        $this->userValidator->with($userData)->passesOrFail(ValidatorInterface::RULE_UPDATE);

                        $user = $this->userRepository->update($userData,$user_id);

                    }

                    $production = Production::find($id);

                    $data = ["descricao_adaptacao"=>$requestPar->all()["descricao_adaptacao"],"adaptada"=>true,"fase_id"=>$production['fase_id']-1];
                    
                    $this->validator->with($data)->passesOrFail(ValidatorInterface::RULE_UPDATE);
                
                    $production = $this->repository->update($data,$id);

                    $productionFile = $this->repository->find($id);

                    $files = $requestPar->file('arquivo');

                    if(!empty($requestPar->file('arquivo'))){
                        foreach ($files as $file) {
        
                            $filename = ["filename"=>"storage/demands".'/'.$productionFile['id']."-".time().".".$file->getClientOriginalExtension()];
                            $file->storeAs('public/demands',$productionFile['id']."-".time().".".$file->getClientOriginalExtension());
                            
                            $data = [
                                'name'=>$productionFile['id']."-".time().".".$file->getClientOriginalExtension(),
                                'original_name'=>$file->getClientOriginalName(),
                                'file'=>$filename['filename'],
                                'owner_id'=>$productionFile['id'],
                                'owner_type'=>'App\\Entities\\Production',
                                'atual'=>true,
                            ];
                            
                            $request = $this->attachmentService->store($data);
                            
                        }
                    }

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