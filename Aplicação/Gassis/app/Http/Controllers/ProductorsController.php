<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use Prettus\Validator\Contracts\ValidatorInterface;
use Prettus\Validator\Exceptions\ValidatorException;
use App\Http\Requests\UserCreateRequest;
use App\Http\Requests\UserUpdateRequest;
use App\Repositories\UserRepository;
use App\Validators\UserValidator;
use App\Services\UserService;
use Illuminate\Support\Facades\Gate;
use App\Entities\User;

/**
 * Class ProductorsController.
 *
 * @package namespace App\Http\Controllers;
 */

class ProductorsController extends Controller
{
    /**
     * @var UserRepository
     */
    protected $repository;

    /**
     * @var UserValidator
     */
    protected $validator;
    protected $service;

    /**
     * UsersController constructor.
     *
     * @param UserRepository $repository
     */
    public function __construct(UserRepository $repository, UserService $service)
    {
        $this->repository = $repository;
        $this->service = $service;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function register(){

        if(Gate::allows('admin')){
            return view('productors.productorAdd');
        }
        else{return view('accessDenied');}
        
    }

    public function index(){
        
        if(Gate::allows('admin')){
            $users = $this->repository->all();

            return view('productors.index',[
                'users' => $users,
            ]);
        }
        else{return view('accessDenied');}

    }

    public function removeds(){

        if(Gate::allows('admin')){
            
            $users =  User::onlyTrashed()->get();
            
            if($users!=null){}

            return view('productors.removed',[
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

            return redirect()->route('productorRemoved');
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
            
            $request = $this->service->store($requestPar->all(),3);

            session()->flash('success',[
                'success'      => $request['success'],
                'messages'     => $request['message']
            ]);
              
            return view('productors.productorAdd');
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

        if(Gate::allows('admOrReq')){
        
            $user = $this->repository->find($id["id"]);

            return view('productors.productorEdit',[
                'user' => $user,
            ]);
        }
        else{return view('accessDenied');}
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
    
            return redirect()->route('productor.index');
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
    
            return redirect()->route('productor.index');
        }
         else{return view('accessDenied');}

    }
}


