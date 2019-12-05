<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use Prettus\Validator\Contracts\ValidatorInterface;
use Prettus\Validator\Exceptions\ValidatorException;
use App\Http\Requests\DemandCreateRequest;
use App\Http\Requests\DemandUpdateRequest;
use App\Repositories\TipoSolicitanteRepository;
use App\Validators\DemandValidator;
use App\Repositories\ProductionRepository;
use App\Repositories\DemandRepository;
use App\Services\DemandService;
use App\Entities\TipoSolicitante;
use App\Entities\Demand;
use Illuminate\Support\Facades\Gate;
use App\Entities\Production;
Use App\Repositories\GenericFunctionsForRepository;
use Illuminate\Support\Facades\Storage;
use App\Http\Controllers\DemandsController;
use App\Services\ProductionService;

/**
 * 
 * 
 * 
 * Class ProductionController.
 *
 * @package namespace App\Http\Controllers;
 */

class ProductionsController extends Controller
{
    /**
     * @var GenericFunctionsForRepository
     */
    protected $repositoryFunctions;

    /**
     * @var ProductionRepository
     */
    protected $repository;

    /**
     * @var DemandRepository
     */
    protected $demandRepository;

    /**
     * @var ProductionValidator
     */
    protected $validator;
    protected $service;

    /**
     * ProductionssController constructor.
     *
     * @param ProductionRepository $repository
     * @param DemandRepository $demandRepository
     */
    public function __construct(ProductionRepository $repository, ProductionService $service, DemandRepository $demandRepository)
    {
        $this->repository = $repository;
        $this->demandRepository = $demandRepository;
        $this->service = $service;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function suspend(){

        if(Gate::allows('admOrProd')){

            $production = $this->repository->all()->find( $_POST["id"]);

            return view('productions.suspenderAdd',['production' => $production]);
        }
        else{return view('accessDenied');}
        
    }
    
    public function startProduction(){
        if(Gate::allows('admReqProd')){
            $production = $this->repository->all()->find($_POST['id']);
            if($production!=null){
                return view('productions.detalhes',[
                    'productions' => $production,
                ]);
            }
        }
        else{return view('accessDenied');}

    }

    public function show(Request $id){
        if(Gate::allows('admReqProd')){

            $production = $this->repository->all()->find($id['production']);

            if($production!=null){
                return view('productions.detalhes',['production' => $production]);
            }
        }
        else{return view('accessDenied');}

    }

    public function materialShow(Request $id){
        if(Gate::allows('assisted')){

            $production = Production::find($_POST['id']);

            $demandShow = Demand::find($production['demand_id']);

            $extensao = substr($demandShow->filename, strpos($demandShow->filename, '.')+1 );
    
            $nomeArquivo = substr($demandShow->filename, strpos($demandShow->filename, 's/')+2 );

            $production = $this->repository->all()->find($_POST['id']);

            if($production!=null){
                return view('productions.materialDetalhes',
                [
                    'production' => $production,
                    'extensao'  => $extensao,
                    'nomeArquivo'  => $nomeArquivo
                ]);
            }
        }
        else{return view('accessDenied');}

    }

    public function index(){

        if(Gate::allows('admReqProd')){
            if(auth()->user()->permission==3){

                $productions = $this->repository->findwhere(['productor_id'=>auth()->user()->id]);

                if($productions->all()!=null){

                    foreach ($productions->all() as $key => $value) {

                        if($value['current_state_id']!=null){

                            $retomar = true;
    
                        }
                        else{
    
                            $retomar = false;
    
                        }

                    }

                    return view('productions.index',[
                        'productions' => $productions,
                        'retomar'=>$retomar
                    ]);

                }
                else{
                    return view('productions.index',[
                        'productions'=>$productions,
                        'retomar'=>null
                    ]);
                }

            }

            else{

                $productions = $this->repository->all();

                    return view('productions.index',[
                        'productions' => $productions,
                    ]);
            }
        }
        else{return view('accessDenied');}
        

    }

    public function materiais(){

        if(Gate::allows('assisted')){
            if(auth()->user()->permission==1){

                $productions = $this->repository->findwhere(['fase_id'=>3]);

                if($productions!=null){
                    return view('productions.materiais',[
                        'productions' => $productions,
                    ]);
                }
                else{
                    return view('productions.materiais');
                }

            }
        }
        else{return view('accessDenied');}

    }



    public function removeds(){

        if(Gate::allows('admOrProd')){
            
            $productions =  Production::onlyTrashed()->get();
            
            if($productions!=null){
                return view('productions.removed',[
                    'productions' => $productions,
                ]);
            }

        }
        else{return view('accessDenied');}

    }

    public function recover()
    {
        if(Gate::allows('admOrReq')){

            $production =  Production::onlyTrashed()->where('id', $_POST["id"])->restore();

            return redirect()->route('productionRemoved');
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

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     *
     * @return \Illuminate\Http\Response
     */
    /**
     * Update the specified resource in storage.
     *
     * @param  ProductionUpdateRequest $request
     * @param  string            $id
     *
     * @return Response
     *
     * @throws \Prettus\Validator\Exceptions\ValidatorException
     */


    public function update()
    {
        if(Gate::allows('admAssisProd')){

            if($_POST['function']==2){
                $request = $this->service->update($_POST['id'],$_POST['function'],$_POST['descricao']);
            }
            else{
                $request = $this->service->update($_POST['id'],$_POST['function'],null);
            }

            session()->flash('success',[
                'success'      => $request['success'],
                'messages'     => $request['message']
            ]);

            if(auth()->user()->permission==1){return redirect()->route('productionMateriais');}
            else{return redirect()->route('production.index');}
            
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

        if(Gate::allows('admOrReq')){
            
            $request = $this->service->destroy($id);

            session()->flash('success',[
                'success'      => $request['success'],
                'messages'     => $request['message']
            ]);

            return redirect()->route('production.index');
        }
        else{return view('accessDenied');}

        
    }
}


