<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use Prettus\Validator\Contracts\ValidatorInterface;
use Prettus\Validator\Exceptions\ValidatorException;
use App\Http\Requests\tipoSolicitanteCreateRequest;
use App\Http\Requests\tipoSolicitanteUpdateRequest;
use App\Repositories\TipoSolicitanteRepository;
use App\Validators\TipoSolicitanteValidator;
use App\Services\TipoSolicitanteService;
use Illuminate\Support\Facades\Gate;
use App\Entities\TipoSolicitante;


/**
 * Class TipoSolicitantesController.
 *
 * @package namespace App\Http\Controllers;
 */
class TipoSolicitantesController extends Controller
{
    /**
     * @var TipoSolicitanteRepository
     */
    protected $repository;

    /**
     * @var TipoSolicitanteValidator
     */
    protected $validator;

    protected $service;

    /**
     * TipoSolicitantesController constructor.
     *
     * @param TipoSolicitanteRepository $repository
     * @param TipoSolicitanteValidator $validator
     */
    public function __construct(TipoSolicitanteRepository $repository, TipoSolicitanteValidator $validator,TipoSolicitanteService $service)
    {
        $this->repository = $repository;
        $this->validator  = $validator;
        $this->service = $service;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        if(Gate::allows('admin')){
            $tipoSolicitantes = $this->repository->all();

            return view('admins.tipoSolicitanteAdd',[
                'tipoSolicitantes' => $tipoSolicitantes,
            ]);
        }
        else{return view('accessDenied');}

    }

    public function removeds(){

        if(Gate::allows('admin')){
            
            $tipos =  TipoSolicitante::onlyTrashed()->get();
            
            if($tipos!=null){}

            return view('admins.tipoSolicitanteRemoved',[
                'tipoSolicitantes' => $tipos,
            ]);

        }
        else{return view('accessDenied');}

    }

    public function recover()
    {
        if(Gate::allows('admin')){

            $tipo =  TipoSolicitante::onlyTrashed()->where('id', $_POST["id"])->restore();

            return redirect()->route('tipoSolRemoved');
        }
        else{return view('accessDenied');}

        
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  TipoSolicitanteCreateRequest $request
     *
     * @return \Illuminate\Http\Response
     *
     * @throws \Prettus\Validator\Exceptions\ValidatorException
     */


    public function store(TipoSolicitanteCreateRequest $requestPar)
    {

        if(Gate::allows('admin')){
            $request = $this->service->store($requestPar->all());

            //$req = $request['success'] ? $request['data']: null;

            session()->flash('success',[
                'success'      => $request['success'],
                'messages'     => $request['message']
            ]);
            
            return redirect()->route('tipoSol.index');
        }
        else{return view('accessDenied');}

    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     *
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $tipoSolicitante = $this->repository->find($id);

        if (request()->wantsJson()) {

            return response()->json([
                'data' => $tipoSolicitante,
            ]);
        }

        return view('tipoSolicitantes.show', compact('tipoSolicitante'));
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
        $tipoSolicitante = $this->repository->find($id);

        return view('tipoSolicitantes.edit', compact('tipoSolicitante'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  TipoSolicitanteUpdateRequest $request
     * @param  string            $id
     *
     * @return Response
     *
     * @throws \Prettus\Validator\Exceptions\ValidatorException
     */
    public function update(TipoSolicitanteUpdateRequest $request, $id)
    {
        try {

            $this->validator->with($request->all())->passesOrFail(ValidatorInterface::RULE_UPDATE);

            $tipoSolicitante = $this->repository->update($request->all(), $id);

            $response = [
                'message' => 'TipoSolicitante updated.',
                'data'    => $tipoSolicitante->toArray(),
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
            $deleted = $this->repository->delete($id);

            if (request()->wantsJson()) {
    
                return response()->json([
                    'message' => 'TipoSolicitante deleted.',
                    'deleted' => $deleted,
                ]);
            }
    
            return redirect()->back()->with('message', 'TipoSolicitante deleted.');
        }
        else{return view('accessDenied');}
    }
}
