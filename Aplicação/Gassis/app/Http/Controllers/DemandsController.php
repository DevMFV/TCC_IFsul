<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use Prettus\Validator\Contracts\ValidatorInterface;
use Prettus\Validator\Exceptions\ValidatorException;
use App\Http\Requests\DemandCreateRequest;
use App\Http\Requests\DemandUpdateRequest;
use App\Repositories\DemandRepository;
use App\Validators\DemandValidator;

/**
 * Class DemandsController.
 *
 * @package namespace App\Http\Controllers;
 */
class DemandsController extends Controller
{
    /**
     * @var DemandRepository
     */
    protected $repository;

    /**
     * @var DemandValidator
     */
    protected $validator;

    /**
     * DemandsController constructor.
     *
     * @param DemandRepository $repository
     * @param DemandValidator $validator
     */
    public function __construct(DemandRepository $repository, DemandValidator $validator)
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
        $demands = $this->repository->all();

        if (request()->wantsJson()) {

            return response()->json([
                'data' => $demands,
            ]);
        }

        return view('demands.index', compact('demands'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  DemandCreateRequest $request
     *
     * @return \Illuminate\Http\Response
     *
     * @throws \Prettus\Validator\Exceptions\ValidatorException
     */
    public function store(DemandCreateRequest $request)
    {
        try {

            $this->validator->with($request->all())->passesOrFail(ValidatorInterface::RULE_CREATE);

            $demand = $this->repository->create($request->all());

            $response = [
                'message' => 'Demand created.',
                'data'    => $demand->toArray(),
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
        $demand = $this->repository->find($id);

        if (request()->wantsJson()) {

            return response()->json([
                'data' => $demand,
            ]);
        }

        return view('demands.show', compact('demand'));
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
        $demand = $this->repository->find($id);

        return view('demands.edit', compact('demand'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  DemandUpdateRequest $request
     * @param  string            $id
     *
     * @return Response
     *
     * @throws \Prettus\Validator\Exceptions\ValidatorException
     */
    public function update(DemandUpdateRequest $request, $id)
    {
        try {

            $this->validator->with($request->all())->passesOrFail(ValidatorInterface::RULE_UPDATE);

            $demand = $this->repository->update($request->all(), $id);

            $response = [
                'message' => 'Demand updated.',
                'data'    => $demand->toArray(),
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
                'message' => 'Demand deleted.',
                'deleted' => $deleted,
            ]);
        }

        return redirect()->back()->with('message', 'Demand deleted.');
    }
}
