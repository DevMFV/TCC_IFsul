<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use Prettus\Validator\Contracts\ValidatorInterface;
use Prettus\Validator\Exceptions\ValidatorException;
use App\Http\Requests\TipoDeficienciaCreateRequest;
use App\Http\Requests\TipoDeficienciaUpdateRequest;
use App\Repositories\TipoDeficienciaRepository;
use App\Validators\TipoDeficienciaValidator;

/**
 * Class TipoDeficienciasController.
 *
 * @package namespace App\Http\Controllers;
 */
class TipoDeficienciasController extends Controller
{
    /**
     * @var TipoDeficienciaRepository
     */
    protected $repository;

    /**
     * @var TipoDeficienciaValidator
     */
    protected $validator;

    /**
     * TipoDeficienciasController constructor.
     *
     * @param TipoDeficienciaRepository $repository
     * @param TipoDeficienciaValidator $validator
     */
    public function __construct(TipoDeficienciaRepository $repository, TipoDeficienciaValidator $validator)
    {
        $this->repository = $repository;
        $this->validator  = $validator;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $this->repository->pushCriteria(app('Prettus\Repository\Criteria\RequestCriteria'));
        $tipoDeficiencias = $this->repository->all();

        if (request()->wantsJson()) {

            return response()->json([
                'data' => $tipoDeficiencias,
            ]);
        }

        return view('tipoDeficiencias.index', compact('tipoDeficiencias'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  TipoDeficienciaCreateRequest $request
     *
     * @return \Illuminate\Http\Response
     *
     * @throws \Prettus\Validator\Exceptions\ValidatorException
     */
    public function store(TipoDeficienciaCreateRequest $request)
    {
        try {

            $this->validator->with($request->all())->passesOrFail(ValidatorInterface::RULE_CREATE);

            $tipoDeficiencium = $this->repository->create($request->all());

            $response = [
                'message' => 'TipoDeficiencia created.',
                'data'    => $tipoDeficiencium->toArray(),
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
     * Display the specified resource.
     *
     * @param  int $id
     *
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $tipoDeficiencium = $this->repository->find($id);

        if (request()->wantsJson()) {

            return response()->json([
                'data' => $tipoDeficiencium,
            ]);
        }

        return view('tipoDeficiencias.show', compact('tipoDeficiencium'));
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
        $tipoDeficiencium = $this->repository->find($id);

        return view('tipoDeficiencias.edit', compact('tipoDeficiencium'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  TipoDeficienciaUpdateRequest $request
     * @param  string            $id
     *
     * @return Response
     *
     * @throws \Prettus\Validator\Exceptions\ValidatorException
     */
    public function update(TipoDeficienciaUpdateRequest $request, $id)
    {
        try {

            $this->validator->with($request->all())->passesOrFail(ValidatorInterface::RULE_UPDATE);

            $tipoDeficiencium = $this->repository->update($request->all(), $id);

            $response = [
                'message' => 'TipoDeficiencia updated.',
                'data'    => $tipoDeficiencium->toArray(),
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
                'message' => 'TipoDeficiencia deleted.',
                'deleted' => $deleted,
            ]);
        }

        return redirect()->back()->with('message', 'TipoDeficiencia deleted.');
    }
}
