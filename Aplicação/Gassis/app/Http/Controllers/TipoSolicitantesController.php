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
        $tipoSolicitantes = $this->repository->all();

        return view('admins.tipoSolicitanteAdd',[
            'tipoSolicitantes' => $tipoSolicitantes,
        ]);

        /*
        $this->repository->pushCriteria(app('Prettus\Repository\Criteria\RequestCriteria'));
        $tipoSolicitantes = $this->repository->all();

        if (request()->wantsJson()) {

            return response()->json([
                'data' => $tipoSolicitantes,
            ]);
        }

        return view('tipoSolicitantes.tipoSolicitanteAdd', compact('tipoSolicitantes'));
        */
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
    
      $request = $this->service->store($requestPar->all());

      //$req = $request['success'] ? $request['data']: null;

      session()->flush('success',[
          'success'      => $request['success'],
          'messages'     => $request['message']
      ]);
        
      return view('admins.tipoSolicitanteAdd');

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
        $deleted = $this->repository->delete($id);

        if (request()->wantsJson()) {

            return response()->json([
                'message' => 'TipoSolicitante deleted.',
                'deleted' => $deleted,
            ]);
        }

        return redirect()->back()->with('message', 'TipoSolicitante deleted.');
    }
}
