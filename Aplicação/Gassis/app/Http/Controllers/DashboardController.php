<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Repositories\RequesterRepository;
use App\Validators\RequesterValidator;
use Auth;
use PHPUnit\Framework\Exception;

class DashboardController extends Controller
{
    /**
     * @var DasboardRepository
     */
    private $repository;

    /**
     * @var DasboardValidator
     */
    private $validator;

    
    public function __construct(RequesterRepository $repository, RequesterValidator $validator)
    {
        $this->repository = $repository;
        $this->validator  = $validator;
    }

    public function index(){
        return redirect()->route('dashboard');
    }

    public function logout(){
        Auth::logout();
        return redirect()->route('/login');
    }

    public function auth(Request $request){
        
        $data = array(
            "email"=>$request->get('requesterlogin'),
            "password"=>$request->get('requesterpassword')
        );

        try{

            // Se deve criptografar
            if(env('PASSWORD_HASH')){
                \Auth::attempt($data, true);
            }

            else{

                //busca pelo email informado
                $requester=$this->repository->findWhere(['email' => $request->get('requesterlogin')])->first();

                // Verifica se achou o objeto
                if(!$requester){
                    throw new Exception("Email invalido!");
                }
                // se achou, verefica se a senha do objeto é a mesma que foi informada
                else if($requester->password != $request->get('requesterpassword')){
                    throw new Exception("Senha invalido!");
                }
                // se estiver tudo certo, autentica.
                else{Auth::login($requester);}

            }

            return redirect()->route('index');
        }
        catch(\Exeption $e){
            return $e->getMessage();
        }

        

        dd($request->all());
    }
}
