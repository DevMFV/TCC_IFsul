<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use Prettus\Validator\Contracts\ValidatorInterface;
use Prettus\Validator\Exceptions\ValidatorException;
use App\Http\Requests\UserCreateRequest;
use App\Http\Requests\UserUpdateRequest;
use App\Repositories\UserRepository;
use App\Repositories\TipoSolicitanteRepository;
use App\Validators\UserValidator;
use App\Services\UserService;
use App\Entities\TipoSolicitante;
use App\Entities\User;
use Illuminate\Support\Facades\Gate;

/**
 * Class RequestersController.
 *
 * @package namespace App\Http\Controllers;
 */

class RequestersController extends Controller
{
    /**
     * @var UserRepository
     */
    protected $repository;

    /**
     * @var TipoSolicitanteRepository
     */
    protected $tipoRepository;

    /**
     * @var UserValidator
     */
    protected $validator;
    protected $service;

    /**
     * UsersController constructor.
     *
     * @param UserRepository $repository
     * @param TipoSolicitanteRepository $tipoRepository
     */
    public function __construct(UserRepository $repository, UserService $service, TipoSolicitanteRepository $tipoRepository)
    {
        $this->repository = $repository;
        $this->tipoRepository = $tipoRepository;
        $this->service = $service;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    

    public function register(){

        if(Gate::allows('admin')){

            $tiposSolicitante = $this->tipoRepository->all();
            $tipoSolicitanteList = TipoSolicitante::pluck('tipo','id')->all();

            return view('requesters.requesterAdd',[
                'tiposSolicitante' => $tiposSolicitante,
                'tipoSolicitanteList' => $tipoSolicitanteList
            ]);
        }
        else{return view('accessDenied');}
        
    }

    public function index(){

        if(Gate::allows('admin')){
            $users = $this->repository->all();

            if($users!=null){}

            return view('requesters.index',[
                'users' => $users,
            ]);

            dd($users);
        }
        else{return view('accessDenied');}

    }

    public function removeds(){

        if(Gate::allows('admin')){
            
            $users =  User::onlyTrashed()->get();
            
            if($users!=null){}

            return view('requesters.removed',[
                'users' => $users,
            ]);

            dd($users);
        }
        else{return view('accessDenied');}

    }

    public function recover()
    {
        if(Gate::allows('admin')){

            $user =  User::onlyTrashed()->where('id', $_POST["id"])->restore();

            return redirect()->route('requesterRemoved');
        }
        else{return view('accessDenied');}

        
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  UserCreateRequest $request
     *
     * @return \Illuminate\Http\Response
     *
     * @throws \Prettus\Validator\Exceptions\ValidatorException
     */

    public function store(UserCreateRequest $requestPar)
    {

        if(Gate::allows('admin')){
            $request = $this->service->store($requestPar->all(),2);

            session()->flash('success',[
                'success'      => $request['success'],
                'messages'     => $request['message']
            ]);
            
            $tipoSolicitanteList = TipoSolicitante::pluck('tipo','id')->all();
            
            return view('requesters.requesterAdd',[
                'tipoSolicitanteList' => $tipoSolicitanteList
            ]);
        }
        else{return view('accessDenied');}

    }

    /**
     * Display the specified res$userurce.
     *
     * @param  int $id
     *
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $user = $this->repository->find($id);

        if (request()->wantsJson()) {

            return response()->json([
                'data' => $user,
            ]);
        }

        return view('users.show', compact('user'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     *
     * @return \Illuminate\Http\Response
     */


    public function edit(Request $id)
    {
        $user = $this->repository->find($id["id"]);

        $tiposSolicitante = $this->tipoRepository->all();

        $tipoSolicitanteList = TipoSolicitante::pluck('tipo','id')->all();

        return view('requesters.requesterEdit',[
            'user'                  =>  $user,
            'tiposSolicitante'      =>  $tiposSolicitante,
            'tipoSolicitanteList'   =>  $tipoSolicitanteList
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  UserUpdateRequest $request
     * @param  string            $id
     *
     * @return Response
     *
     * @throws \Prettus\Validator\Exceptions\ValidatorException
     */


    public function update(Request $requestPar, $id)
    {
        if(Gate::allows('admin')){

            $request = $this->service->update($requestPar->all(),$id);

            session()->flash('success',[
                'success'      => $request['success'],
                'messages'     => $request['message']
            ]);
    
            return redirect()->route('requester.index');
        }
        else{return view('accessDenied');}
    }


    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     *
     * @return \Illuminate\Http\Response
     */


    public function destroy($id)
    {

        if(Gate::allows('admin')){
            $request = $this->service->destroy($id);

            session()->flash('success',[
                'success'      => $request['success'],
                'messages'     => $request['message']
            ]);

            return redirect()->route('requester.index');
        }
        else{return view('accessDenied');}

        
    }
}


