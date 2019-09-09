<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use Prettus\Validator\Contracts\ValidatorInterface;
use Prettus\Validator\Exceptions\ValidatorException;
use App\Http\Requests\AdminCreateRequest;
use App\Http\Requests\AdminUpdateRequest;
use App\Repositories\AdminRepository;
use App\Validators\AdminValidator;
use App\Services\AdminService;
use Illuminate\Support\Facades\Gate;

/**
 * Class AdminsController.
 *
 * @package namespace App\Http\Controllers;
 */
class AdminsController extends Controller
{
    /**
     * @var AdminRepository
     */
    protected $repository;

    /**
     * @var AdminValidator
     */
    protected $validator;
    protected $service;

    /**
     * AdminsController constructor.
     *
     * @param AdminRepository $repository
     */
    public function __construct(AdminRepository $repository, AdminService $service)
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
            return view('admins.adminAdd');
        }
        else{return view('accessDenied');}
        
    }

    public function index(){
        
        if(Gate::allows('admin')){
            $admins = $this->repository->all();

            return view('admins.index',[
                'admins' => $admins,
            ]);
        }
        else{return view('accessDenied');}
    
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  AdminCreateRequest $request
     *
     * @return \Illuminate\Http\Response
     *
     * @throws \Prettus\Validator\Exceptions\ValidatorException
     */
    public function store(AdminCreateRequest $requestPar)
    {

        if(Gate::allows('admin')){
            $request = $this->service->store($requestPar->all(),2);

            $req = $request['success'] ? $request['data']: null;
                
            session()->flash('success',[
                'success'      => $request['success'],
                'messages'     => $request['message']
            ]);
            
            return view('admins.adminAdd');
        }
        else{return view('accessDenied');}  

    }

    /**
     * Display the specified res$adminurce.
     *
     * @param  int $id
     *
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $admin = $this->repository->find($id);

        if (request()->wantsJson()) {

            return response()->json([
                'data' => $admin,
            ]);
        }

        return view('admins.show', compact('admin'));
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
        $admin = $this->repository->find($id);

        return view('admins.edit', compact('admin'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  AdminUpdateRequest $request
     * @param  string            $id
     *
     * @return Response
     *
     * @throws \Prettus\Validator\Exceptions\ValidatorException
     */
    public function update(AdminUpdateRequest $request, $id)
    {
        try {

            $this->validator->with($request->all())->passesOrFail(ValidatorInterface::RULE_UPDATE);

            $admin = $this->repository->update($request->all(), $id);

            $response = [
                'message' => 'Admin updated.',
                'data'    => $admin->toArray(),
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

            session()->flush('success',[
                'success'      => $request['success'],
                'messages'     => $request['message']
            ]);
    
            return redirect()->route('admin.index');
        }
        else{return view('accessDenied');}
        
    }
}


