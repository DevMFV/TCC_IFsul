<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use Prettus\Validator\Contracts\ValidatorInterface;
use Prettus\Validator\Exceptions\ValidatorException;
use App\Http\Requests\FaseCreateRequest;
use App\Http\Requests\FaseUpdateRequest;
use App\Repositories\FaseRepository;
use App\Validators\FaseValidator;

/**
 * Class FasesController.
 *
 * @package namespace App\Http\Controllers;
 */
class FasesController extends Controller
{
    /**
     * @var FaseRepository
     */
    protected $repository;

    /**
     * @var FaseValidator
     */
    protected $validator;

    /**
     * FasesController constructor.
     *
     * @param FaseRepository $repository
     * @param FaseValidator $validator
     */
    public function __construct(FaseRepository $repository, FaseValidator $validator)
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
        $fases = $this->repository->all();

        if (request()->wantsJson()) {

            return response()->json([
                'data' => $fases,
            ]);
        }

        return view('fases.index', compact('fases'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  FaseCreateRequest $request
     *
     * @return \Illuminate\Http\Response
     *
     * @throws \Prettus\Validator\Exceptions\ValidatorException
     */
    public function store(FaseCreateRequest $request)
    {
        try {

            $this->validator->with($request->all())->passesOrFail(ValidatorInterface::RULE_CREATE);

            $fase = $this->repository->create($request->all());

            $response = [
                'message' => 'Fase created.',
                'data'    => $fase->toArray(),
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
        $fase = $this->repository->find($id);

        if (request()->wantsJson()) {

            return response()->json([
                'data' => $fase,
            ]);
        }

        return view('fases.show', compact('fase'));
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
        $fase = $this->repository->find($id);

        return view('fases.edit', compact('fase'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  FaseUpdateRequest $request
     * @param  string            $id
     *
     * @return Response
     *
     * @throws \Prettus\Validator\Exceptions\ValidatorException
     */
    public function update(FaseUpdateRequest $request, $id)
    {
        try {

            $this->validator->with($request->all())->passesOrFail(ValidatorInterface::RULE_UPDATE);

            $fase = $this->repository->update($request->all(), $id);

            $response = [
                'message' => 'Fase updated.',
                'data'    => $fase->toArray(),
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
                'message' => 'Fase deleted.',
                'deleted' => $deleted,
            ]);
        }

        return redirect()->back()->with('message', 'Fase deleted.');
    }
}
