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
use App\Services\RequesterService;

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
    protected $service;

    /**
     * RequestersController constructor.
     *
     * @param RequesterRepository $repository
     */
    public function __construct(RequesterRepository $repository, RequesterService $service)
    {
        $this->repository = $repository;
        $this->service = $service;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function register(){
        return view('requesters.requesterAdd');
    }

    public function index(){
        
        $requesters = $this->repository->all();

        return view('requesters.index',[
            'requesters' => $requesters,
        ]);
    
        

        /*$this->repository->pushCriteria(app('Prettus\Repository\Criteria\RequestCriteria'));
        $requesters = $this->repository->all();

        if (request()->wantsJson()) {

            return response()->json([
                'data' => $requesters,
            ]);
        }

        return view('requesters.index', compact('requesters'));
        */

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
    public function store(RequesterCreateRequest $requestPar)
    {
      
      $request = $this->service->store($requestPar->all());

      $req = $request['success'] ? $request['data']: null;

      session()->flush('success',[
          'success'      => $request['success'],
          'messages'     => $request['message']
      ]);
        
        return view('requesters.requesterAdd',['requester'=>$req]);
    }

    /**
     * Display the specified res$requesterurce.
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
