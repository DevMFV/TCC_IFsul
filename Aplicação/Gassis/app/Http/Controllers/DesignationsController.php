<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;


use Illuminate\Support\Facades\Gate;

use App\Http\Requests;
use Prettus\Validator\Contracts\ValidatorInterface;
use Prettus\Validator\Exceptions\ValidatorException;
use App\Http\Requests\DesignationCreateRequest;
use App\Http\Requests\DesignationUpdateRequest;
use App\Repositories\DesignationRepository;
use App\Validators\DesignationValidator;
use App\Repositories\UserRepository;
use App\Repositories\ProductionRepository;
use App\Services\UserService;
use App\Services\DesignationService;

/**
 * Class DesignationsController.
 *
 * @package namespace App\Http\Controllers;
 */
class DesignationsController extends Controller
{
   
    /**
     * @var GenericFunctionsForRepository
     */
    protected $repositoryFunctions;

    /**
     * @var DesignationValidator
     */
    protected $validator;
    protected $service;

    /**
     * @var DesignationRepository
     */
    protected $repository;

    /**
     * @var ProductionRepository
     */
    protected $productionRepository;

    /**
     * @var UserRepository
     */
    protected $userRepository;

    /**
     * @var UserService
     */
    protected $userService;

    /**
     * DesignationssController constructor.
     *
     * @param DesignationRepository $repository
     * @param UserRepository $userRepository
     */
    public function __construct(DesignationRepository $repository, DesignationService $service, 
    ProductionRepository $productionRepository,
    UserRepository $userRepository,UserService $userService )
    {
        $this->repository = $repository;
        $this->service = $service;
        $this->productionRepository = $productionRepository;
        $this->userRepository = $userRepository;
        $this->userService = $userService;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function chooseProductor(){

        if(Gate::allows('admin')){

            $productors = $this->userRepository->findwhere(['permission'=>3]);

            return view('designations.designationAdd',['productors' => $productors,'demandId'=>$_POST["demandId"]]);
        }
        else{return view('accessDenied');}
        
    }

    public function designate(){
        
        if(Gate::allows('admin')){

           $start = $this->service->designate($_POST["id"],$_POST["demandId"]);

           return redirect()->route('demand.index');
        }

        else{return view('accessDenied');}

    }

    public function show(){
        if(Gate::allows('admReqProd')){

            $e = $this->repository->findwhere(['production_id'=>$_POST["id"],'atual'=>true]);

            //$designation = $this->repository->all()->find($designationId);

            if($e!=null){
                return view('designations.detalhes',['designation' => $e->all()[0]]);
            }
            
        }
        else{return view('accessDenied');}

    }

    public function index(){

        if(Gate::allows('admReqProd')){

            if(auth()->user()->permission==2){

                $designations = $this->repository->findwhere(['requester_id'=>auth()->user()->id]);

                if($designations!=null){
                    return view('designations.index',[
                        'designations' => $designations,
                    ]);
                }
                else{
                    return view('designations.index');
                }

            }
            
            else{

                $designations = $this->repository->all();

                if($designations!=null){
                    return view('designations.index',[
                        'designations' => $designations,
                    ]);
                }
                else{
                    return view('designations.index');
                }
            }
        }
        else{return view('accessDenied');}

    }

    public function removeds(){

        if(Gate::allows('admOrReq')){
            
            $designations =  Designation::onlyTrashed()->get();
            
            if($designations!=null){}

            return view('designations.removed',[
                'designations' => $designations,
            ]);

            dd($designations);
        }
        else{return view('accessDenied');}

    }

    public function recover()
    {
        if(Gate::allows('admOrReq')){

            $designation =  Designation::onlyTrashed()->where('id', $_POST["id"])->restore();

            return redirect()->route('designationRemoved');
        }
        else{return view('accessDenied');}
    }

    /**
     * Store a newly created resource in storage.
     *
     * 
     *
     * @param  Request $requestt
     *
     * @return \Illuminate\Http\Response
     *
     * @throws \Prettus\Validator\Exceptions\ValidatorException
     */

    public function store(Request $requestPar)
    {

        if(Gate::allows('assisted')){
            
            $request = $this->service->update($_POST['productionId']);

            $requeststore = $this->service->store($requestPar->all());

            $all = $this->repository->all();
            foreach ($all as $key => $value) {$last = $value;}
            if($requestPar->file('arquivo')!=null){
                $requestPar->file('arquivo')->storeAs('public/designations',$last['id'].'.'.$requestPar->file('arquivo')->extension());
                $filename = ["filename"=>"storage/designations".'/'.$last['id'].".".$requestPar->file('arquivo')->extension()];
                $request = $this->service->update($filename,$last['id']);
            }
            
            session()->flash('success',[
                'success'      => $requeststore['success'],
                'messages'     => $requeststore['message'],
            ]);

            $this->productionService->update($_POST['production_id'],'avaliada',null);

            return redirect()->route('productionMateriais');
        }
        else{return view('accessDenied');}

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
        $designation = $this->repository->find($id["id"]);

        $usersAssisted = $this->userRepository->findwhere(['permission'=>'1']);

        $usersAssistedList = User::where(['permission'=>'1'])->pluck('name','id');

        return view('designations.designationEdit',[
            'designation' => $designation,
            'usersAssisted' => $usersAssisted,
            'usersAssistedList' => $usersAssistedList]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  DesignationUpdateRequest $request
     * @param  string            $id
     *
     * @return Response
     *
     * @throws \Prettus\Validator\Exceptions\ValidatorException
     */


    public function update(Request $requestPar, $id)
    {

        $request = $this->service->update($requestPar->all(),$id);

        session()->flash('success',[
            'success'      => $request['success'],
            'messages'     => $request['message']
        ]);

        return redirect()->route('designation.index');

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

        if(Gate::allows('admOrReq')){
            $request = $this->service->destroy($id);

            session()->flash('success',[
                'success'      => $request['success'],
                'messages'     => $request['message']
            ]);

            return redirect()->route('designation.index');
        }
        else{return view('accessDenied');}

        
    }
}
