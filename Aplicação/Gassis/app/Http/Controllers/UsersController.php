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

/**
 * Class UsersController.
 *
 * @package namespace App\Http\Controllers;
 */
class UsersController extends Controller
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

        return view('users.userAdd');
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

      $req = $request['success'] ? $request['data']: null;

      session()->flash('success',[
          'success'      => $request['success'],
          'messages'     => $request['message']
      ]);
        
      return view('users.userAdd');

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
    public function updatePassword(UserCreateRequest $requestPar)
    {

        $id = auth()->user()->id;

        $request = $this->service->update($requestPar->all(),$id);

        session()->flash('success',[
            'success'      => $request['success'],
            'messages'     => $request['message']
        ]);

        return redirect()->route('index');

    }

    public function update(UserCreateRequest $requestPar)
    {

        $id = auth()->user()->id;

        $request = $this->service->update($requestPar->all(),$id);

        session()->flash('success',[
            'success'      => $request['success'],
            'messages'     => $request['message']
        ]);

        return redirect()->route('index');

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

        return redirect()->route('user.index');
    }
}


