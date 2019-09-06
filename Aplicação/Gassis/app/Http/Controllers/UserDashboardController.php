<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Repositories\UserRepository;
use App\Validators\UserValidator;
//use Auth;
use PHPUnit\Framework\Exception;
use Illuminate\Support\Facades\Auth;
use Illuminate\Foundation\Auth\User;

class UserDashboardController extends Controller
{
    /**
     * @var DasboardRepository
     */
    private $repository;

    /**
     * @var DasboardValidator
     */
    private $validator;

    
    public function __construct(UserRepository $repository, UserValidator $validator)
    {
        $this->repository = $repository;
        $this->validator  = $validator;
    }

    public function index(){
        return redirect()->route('dashboard');
    }

    public function logout(){
        Auth::logout();
        return redirect()->route('login');
    }

    public function auth(Request $request){

        $data = array(
            "email"=>$request->get('userlogin'),
            "password"=>$request->get('userpassword')
        );

        try{

            // Se deve criptografar
            if(env('PASSWORD_HASH')){
                \Auth::attempt($data, true);
            }

            else{

                //busca pelo email informado
                $User=$this->repository->findWhere(['email' => $request->get('userlogin')])->first();

                // Verifica se achou o objeto
                if(!$User){
                    throw new Exception("Email invalido!");
                }
                // se achou, verefica se a senha do objeto é a mesma que foi informada
                else if($User->password != $request->get('userpassword')){
                    throw new Exception("Senha invalida!");
                }
                // se estiver tudo certo, autentica.
                else{Auth::login($User);}
            }

            return redirect()->route('index');
        }
        catch(\Exeption $e){
            return $e->getMessage();
        }
    }
}
