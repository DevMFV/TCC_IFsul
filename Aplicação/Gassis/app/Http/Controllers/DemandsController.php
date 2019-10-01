<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use Prettus\Validator\Contracts\ValidatorInterface;
use Prettus\Validator\Exceptions\ValidatorException;
use App\Http\Requests\UserCreateRequest;
use App\Http\Requests\UserUpdateRequest;
use App\Repositories\TipoSolicitanteRepository;
use App\Validators\UserValidator;
use App\Repositories\DemandRepository;
use App\Repositories\UserRepository;
use App\Services\UserService;
use App\Entities\TipoSolicitante;
use App\Entities\User;
use Illuminate\Support\Facades\Gate;
Use App\Services\DemandService;
use App\Entities\Demand;
Use App\Repositories\GenericFunctionsForRepository;

/**
 * Class DemandController.
 *
 * @package namespace App\Http\Controllers;
 */

class DemandsController extends Controller
{
    /**
     * @var GenericFunctionsForRepository
     */
    protected $repositoryFunctions;

    /**
     * @var DemandRepository
     */
    protected $repository;

    /**
     * @var UserRepository
     */
    protected $userRepository;

    /**
     * @var DemandValidator
     */
    protected $validator;
    protected $service;

    /**
     * DemandssController constructor.
     *
     * @param DemandRepository $repository
     * @param UserRepository $userRepository
     */
    public function __construct(DemandRepository $repository, DemandService $service, UserRepository $userRepository)
    {
        $this->repository = $repository;
        $this->userRepository = $userRepository;
        $this->service = $service;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function register(){

        if(Gate::allows('requester')){

            $usersAssisted = $this->userRepository->findwhere(['permission'=>'1']);

            $usersAssistedList = User::where(['permission'=>'1'])->pluck('name','id');

            return view('demands.demandAdd',[
                'usersAssisted' => $usersAssisted,
                'usersAssistedList' => $usersAssistedList
            ]);
        }
        else{return view('accessDenied');}
        
    }

    public function details(){

        if(Gate::allows('admReqProd')){

            $demand = $this->repository->all()->find($_POST['id']);
            if($demand!=null){
                return view('demands.detalhes',[
                    'demands' => $demand,
                ]);
            }
        }
        else{return view('accessDenied');}

    }

    public function index(){

        if(Gate::allows('admReqProd')){

            $demands = $this->repository->all();

            if($demands!=null){
                return view('demands.index',[
                    'demands' => $demands,
                ]);
            }
        }
        else{return view('accessDenied');}

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  UserCreateRequest $request
     *
     * @param  Request $requestt
     *
     * @return \Illuminate\Http\Response
     *
     * @throws \Prettus\Validator\Exceptions\ValidatorException
     */

    public function store(UserCreateRequest $requestPar)
    {

        if(Gate::allows('requester')){

            $requeststore = $this->service->store($requestPar->all(),auth()->user()->id);

            $all = $this->repository->all();
            foreach ($all as $key => $value) {$last = $value;}

            $requestPar->file('arquivo')->storeAs('public/demands',$last['id'].'.'.$requestPar->file('arquivo')->extension());

            session()->flash('success',[
                'success'      => $requeststore['success'],
                'messages'     => $requeststore['message']
            ]);
            
            $usersAssistedList = User::where(['permission'=>'1'])->pluck('name','id');

            return view('demands.demandAdd',[
                'usersAssistedList' => $usersAssistedList
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


    public function edit($id)
    {
        $user = $this->repository->find($id);

        return view('users.edit', compact('user'));
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


    public function update(UserUpdateRequest $request, $id)
    {
        try {

            $this->validator->with($request->all())->passesOrFail(ValidatorInterface::RULE_UPDATE);

            $user = $this->repository->update($request->all(), $id);

            $response = [
                'message' => 'User updated.',
                'data'    => $user->toArray(),
            ];

            if ($request->wantsJson()) {

                return response()->json($response);
            }

            return redirect()->back()->with('message', $response['message']);
        } catch (ValidatorException $e) {

            if ($request->wantsJson()) {

                return response()->json([
                    'error'   => true,
                    'message' => $e->getMessageBag()
                ]);
            }

            return redirect()->back()->withErrors($e->getMessageBag())->withInput();
        }
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

            return redirect()->route('demand.index');
        }
        else{return view('accessDenied');}

        
    }
}


