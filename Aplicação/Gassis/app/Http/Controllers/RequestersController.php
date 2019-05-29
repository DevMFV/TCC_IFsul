<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use Prettus\Validator\Contracts\ValidatorInterface;
use Prettus\Validator\Exceptions\ValidatorException;
use App\Http\Requests\RequesterCreateRequest;
use App\Http\Requests\RequesterUpdateRequest;
use App\Repositories\RequesterRepository;
use App\Validators\RequesterValidator;

/**
 * Class RequestersController.
 *
 * @package namespace App\Http\Controllers;
 */
class RequestersController extends Controller
{
    /**
     * @var RequesterRepository
     */
    protected $repository;

    /**
     * @var RequesterValidator
     */
    protected $validator;

    /**
     * RequestersController constructor.
     *
     * @param RequesterRepository $repository
     * @param RequesterValidator $validator
     */
    public function __construct(RequesterRepository $repository, RequesterValidator $validator)
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
        $requesters = $this->repository->all();

        if (request()->wantsJson()) {

            return response()->json([
                'data' => $requesters,
            ]);
        }

        return view('requesters.index', compact('requesters'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  RequesterCreateRequest $request
     *
     * @return \Illuminate\Http\Response
     *
     * @throws \Prettus\Validator\Exceptions\ValidatorException
     */
    public function store(RequesterCreateRequest $request)
    {
        try {

            $this->validator->with($request->all())->passesOrFail(ValidatorInterface::RULE_CREATE);

            $requester = $this->repository->create($request->all());

            $response = [
                'message' => 'Requester created.',
                'data'    => $requester->toArray(),
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
        $requester = $this->repository->find($id);

        if (request()->wantsJson()) {

            return response()->json([
                'data' => $requester,
            ]);
        }

        return view('requesters.show', compact('requester'));
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
        $requester = $this->repository->find($id);

        return view('requesters.edit', compact('requester'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  RequesterUpdateRequest $request
     * @param  string            $id
     *
     * @return Response
     *
     * @throws \Prettus\Validator\Exceptions\ValidatorException
     */
    public function update(RequesterUpdateRequest $request, $id)
    {
        try {

            $this->validator->with($request->all())->passesOrFail(ValidatorInterface::RULE_UPDATE);

            $requester = $this->repository->update($request->all(), $id);

            $response = [
                'message' => 'Requester updated.',
                'data'    => $requester->toArray(),
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
                'message' => 'Requester deleted.',
                'deleted' => $deleted,
            ]);
        }

        return redirect()->back()->with('message', 'Requester deleted.');
    }
}
