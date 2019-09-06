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
        
        $tiposSolicitante = $this->tipoRepository->all();
        $tipoSolicitanteList = TipoSolicitante::pluck('tipo','id')->all();

        return view('requesters.requesterAdd',[
            'tiposSolicitante' => $tiposSolicitante,
            'tipoSolicitanteList' => $tipoSolicitanteList
        ]);
    }

    public function index(){
        
        $users = $this->repository->all();

        return view('requesters.index',[
            'users' => $users,
            
        ]);

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
        $request = $this->service->destroy($id);

        session()->flash('success',[
            'success'      => $request['success'],
            'messages'     => $request['message']
        ]);

        return redirect()->route('requester.index');
    }
}


