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
use App\Repositories\EvaluationRepository;
use App\Repositories\UserRepository;
use App\Services\UserService;
use App\Entities\TipoSolicitante;
use App\Entities\User;
use Illuminate\Support\Facades\Gate;
use App\Services\EvaluationService;
use App\Entities\Evaluation;
use App\Repositories\ProductionRepository;
Use App\Repositories\GenericFunctionsForRepository;
use Illuminate\Support\Facades\Storage;
use App\Services\ProductionService;

/**
 * Class EvaluationController.
 *
 * @package namespace App\Http\Controllers;
 */

class EvaluationsController extends Controller
{
    /**
     * @var GenericFunctionsForRepository
     */
    protected $repositoryFunctions;

    /**
     * @var ProductionRepository
     */
    protected $productionRepository;

    /**
     * @var EvaluationValidator
     */
    protected $validator;
    protected $service;

    /**
     * @var EvaluationRepository
     */
    protected $repository;

    /**
     * @var ProductionService
     */
    protected $productionService;

    /**
     * EvaluationssController constructor.
     *
     * @param EvaluationRepository $repository
     * @param UserRepository $userRepository
     */
    public function __construct(EvaluationRepository $repository, EvaluationService $service, ProductionRepository $productionRepository,
    ProductionService $productionService )
    {
        $this->repository = $repository;
        $this->productionRepository = $productionRepository;
        $this->service = $service;
        $this->productionService = $productionService;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function register(){

        if(Gate::allows('assisted')){

            $production = $this->productionRepository->all()->find( $_POST["id"]);

            return view('evaluations.evaluationAdd',['production' => $production]);
        }
        else{return view('accessDenied');}
        
    }


    public function startProduction(){
        
        if(Gate::allows('prod')){

           $start = $this->service->startProduction($_POST["id"]);

           return redirect()->route('evaluation.index');
        }

        else{return view('accessDenied');}

    }

    



    public function show(){
        if(Gate::allows('admReqProd')){

            $e = $this->repository->findwhere(['production_id'=>$_POST["id"],'atual'=>true]);

            $evaluation = Evaluation::with('anexos')->where(['production_id'=>$_POST['id'],'atual'=>true])->first();

            $anexos = $evaluation['anexos']->all();

            if($e!=null){
                return view('evaluations.detalhes',[
                    'evaluation' => $e->all()[0],
                    'anexos' => $anexos,
                    ]);
            }
            
        }
        else{return view('accessDenied');}

    }

    public function index(){

        if(Gate::allows('admReqProd')){

            if(auth()->user()->permission==2){

                $evaluations = $this->repository->findwhere(['requester_id'=>auth()->user()->id]);

                if($evaluations!=null){
                    return view('evaluations.index',[
                        'evaluations' => $evaluations,
                    ]);
                }
                else{
                    return view('evaluations.index');
                }

            }
            
            else{

                $evaluations = $this->repository->all();

                if($evaluations!=null){
                    return view('evaluations.index',[
                        'evaluations' => $evaluations,
                    ]);
                }
                else{
                    return view('evaluations.index');
                }
            }
        }
        else{return view('accessDenied');}

    }

    public function removeds(){

        if(Gate::allows('admOrReq')){
            
            $evaluations =  Evaluation::onlyTrashed()->get();
            
            if($evaluations!=null){}

            return view('evaluations.removed',[
                'evaluations' => $evaluations,
            ]);

            dd($evaluations);
        }
        else{return view('accessDenied');}

    }

    public function recover()
    {
        if(Gate::allows('admOrReq')){

            $evaluation =  Evaluation::onlyTrashed()->where('id', $_POST["id"])->restore();

            return redirect()->route('evaluationRemoved');
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

            if($requestPar->file()==[]){
                $arquivo = false;
            }
            else{
                $arquivo = true;
            }
            
            $request = $this->service->update($_POST['production_id']);

            $requeststore = $this->service->store($requestPar->all(),$arquivo);
            
            session()->flash('success',[
                'success'      => $requeststore['success'],
                'messages'     => $requeststore['message'],
            ]);

            $this->productionService->update($_POST['production_id'],'avaliada',null,null);

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
        $evaluation = $this->repository->find($id["id"]);

        $usersAssisted = $this->userRepository->findwhere(['permission'=>'1']);

        $usersAssistedList = User::where(['permission'=>'1'])->pluck('name','id');

        return view('evaluations.evaluationEdit',[
            'evaluation' => $evaluation,
            'usersAssisted' => $usersAssisted,
            'usersAssistedList' => $usersAssistedList]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  EvaluationUpdateRequest $request
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

        return redirect()->route('evaluation.index');

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

            return redirect()->route('evaluation.index');
        }
        else{return view('accessDenied');}

        
    }
}


