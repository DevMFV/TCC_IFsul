<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use Prettus\Validator\Contracts\ValidatorInterface;
use Prettus\Validator\Exceptions\ValidatorException;
use App\Http\Requests\CurrentStateCreateRequest;
use App\Http\Requests\CurrentStateUpdateRequest;
use App\Repositories\CurrentStateRepository;
use App\Validators\CurrentStateValidator;

/**
 * Class CurrentStatesController.
 *
 * @package namespace App\Http\Controllers;
 */
class CurrentStatesController extends Controller
{
    /**
     * @var CurrentStateRepository
     */
    protected $repository;

    /**
     * @var CurrentStateValidator
     */
    protected $validator;

    /**
     * CurrentStatesController constructor.
     *
     * @param CurrentStateRepository $repository
     * @param CurrentStateValidator $validator
     */
    public function __construct(CurrentStateRepository $repository, CurrentStateValidator $validator)
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
        $currentStates = $this->repository->all();

        if (request()->wantsJson()) {

            return response()->json([
                'data' => $currentStates,
            ]);
        }

        return view('currentStates.index', compact('currentStates'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  CurrentStateCreateRequest $request
     *
     * @return \Illuminate\Http\Response
     *
     * @throws \Prettus\Validator\Exceptions\ValidatorException
     */
    public function store(CurrentStateCreateRequest $request)
    {
        try {

            $this->validator->with($request->all())->passesOrFail(ValidatorInterface::RULE_CREATE);

            $currentState = $this->repository->create($request->all());

            $response = [
                'message' => 'CurrentState created.',
                'data'    => $currentState->toArray(),
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
        $currentState = $this->repository->find($id);

        if (request()->wantsJson()) {

            return response()->json([
                'data' => $currentState,
            ]);
        }

        return view('currentStates.show', compact('currentState'));
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
        $currentState = $this->repository->find($id);

        return view('currentStates.edit', compact('currentState'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  CurrentStateUpdateRequest $request
     * @param  string            $id
     *
     * @return Response
     *
     * @throws \Prettus\Validator\Exceptions\ValidatorException
     */
    public function update(CurrentStateUpdateRequest $request, $id)
    {
        try {

            $this->validator->with($request->all())->passesOrFail(ValidatorInterface::RULE_UPDATE);

            $currentState = $this->repository->update($request->all(), $id);

            $response = [
                'message' => 'CurrentState updated.',
                'data'    => $currentState->toArray(),
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
                'message' => 'CurrentState deleted.',
                'deleted' => $deleted,
            ]);
        }

        return redirect()->back()->with('message', 'CurrentState deleted.');
    }
}
