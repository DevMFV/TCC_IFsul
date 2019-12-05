<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Repositories\UserRepository;
use App\Validators\UserValidator;
//use Auth;
use PHPUnit\Framework\Exception;
use Illuminate\Support\Facades\Auth;
use App\Entities\User;
use App\Entities\Demand;
use App\Http\Controllers\UsersController;
use App\Repositories\DemandRepository;
use App\Entities\Attachment;


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

    /**
     * @var UsersController
     */
    protected $usersController;


    /**
     * @var DemandRepository
     */
    protected $demandRepository;
    
    public function __construct(UserRepository $repository, UserValidator $validator, DemandRepository $demandRepository)
    {
        $this->repository = $repository;
        $this->validator  = $validator;
        $this->demandRepository = $demandRepository;
    }

    public function index(){
        return view('index');
    }

    public function show(Request $demand){

        $demandShow = Demand::findOne($demand['demand'])->with(['anexos'])->get();

        return view('demands.detalhesTeste',[
            'demands'       => $demandShow,
            ]);
    }

    public function editPassword(){
        if(auth()->user()->password=="987654321"){

            $user = User::find(auth()->user()->id);

            return view('editPassword',[
                'user' => $user
            ]);
        }
        else{
            return redirect()->route('index');
        }
    }

    /*
    public function updatePassword(){

        

        $update = $this->usersController->updateP($senha,$id);

        session()->flash('success',[
            'success'      => $update['success'],
            'messages'     => $update['message']
        ]);

        return view('index');  

    }
    */

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

            return redirect()->route('editPassword');
        }
        catch(\Exeption $e){
            return $e->getMessage();
        }
    }
}
