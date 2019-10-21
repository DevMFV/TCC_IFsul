<?php

namespace App\Services;

Use App\Repositories\UserRepository;
Use App\Validators\UserValidator;
use Prettus\Validator\Contracts\ValidatorInterface;

class UserService{

    private $validator;
    private $repository;


    public function __construct(UserRepository $repository, UserValidator $validator){

        $this->validator = $validator;
        $this->repository = $repository;
    }

    public function store($data,$p){

        try{

            $data += ["permission"=>$p,"password"=>"987654321"];

            $this->validator->with($data)->passesOrFail(ValidatorInterface::RULE_CREATE);

            $user = $this->repository->create($data);

            return[
                'success'=>true,
                'message'=>'Solicitante cadastrado',
                'data'=> $user
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

    public function update($data,$id){
        try{

            $user = $this->repository->find($id);

            $userUse = $data;
            
            $userUse += ["arquivo"=>null];

            if($userUse["arquivo"]!=null){
                if($user->filename!=null){
                    // DEVE EXCLUIR A IMAGEM ANTERIOR
                    $data["arquivo"]->storeAs('public/assisteds',$user->id.'.'.$user["arquivo"]->extension());
                    $filename = "storage/assisteds".'/'.$user->id.".".$user["arquivo"]->extension();
                }
            
                else{
                    $filename = $data;
                }
                $data += ["filename"=>$filename];
            }

            $this->validator->with($data)->passesOrFail(ValidatorInterface::RULE_UPDATE);

            $user = $this->repository->update($data,$id);

            return[
                'success'=>true,
                'message'=>' atualizado',
                'data'=> $user
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

    public function destroy($user_id){
        try{
            $this->repository->delete($user_id);

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