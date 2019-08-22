<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Repositories\AdminRepository;
use App\Validators\AdminValidator;
//use Auth;
use PHPUnit\Framework\Exception;
use Illuminate\Support\Facades\Auth;

class AdminDashboardController extends Controller
{
    /**
     * @var DasboardRepository
     */
    private $repository;

    /**
     * @var DasboardValidator
     */
    private $validator;

    
    public function __construct(AdminRepository $repository, AdminValidator $validator)
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
            "email"=>$request->get('adminlogin'),
            "password"=>$request->get('adminpassword')
        );

        try{

            // Se deve criptografar
            if(env('PASSWORD_HASH')){
                \Auth::attempt($data, true);
            }

            else{

                //busca pelo email informado
                $Admin=$this->repository->findWhere(['email' => $request->get('adminlogin')])->first();

                // Verifica se achou o objeto
                if(!$Admin){
                    throw new Exception("Email invalido!");
                }
                // se achou, verefica se a senha do objeto é a mesma que foi informada
                else if($Admin->password != $request->get('adminpassword')){
                    throw new Exception("Senha invalida!");
                }
                // se estiver tudo certo, autentica.
                else{Auth::login($Admin);}

            }

            return redirect()->route('index');
        }
        catch(\Exeption $e){
            return $e->getMessage();
        }
    }

    public function reqTables(){
        return view('AdminTables');
    }
}
