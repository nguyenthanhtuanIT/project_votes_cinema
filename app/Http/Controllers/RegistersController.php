<?php

namespace App\Http\Controllers;

use App\Exports\RegistersExport;
use App\Http\Requests\RegisterCreateRequest;
use App\Http\Requests\RegisterUpdateRequest;
use App\Repositories\Contracts\RegisterRepository;
use Excel;
use Illuminate\Http\Request;

/**
 * Class RegistersController.
 *
 * @package namespace App\Http\Controllers;
 */
class RegistersController extends Controller
{
    /**
     * @var RegisterRepository
     */
    protected $repository;

    /**
     * RegistersController constructor.
     *
     * @param RegisterRepository $repository
     */
    public function __construct(RegisterRepository $repository)
    {
        $this->repository = $repository;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $register = $this->repository->all($colums = ['*']);
        return response()->json($register, 201);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  RegisterCreateRequest $request
     *
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $register = $this->repository->create($request->all());

        return response()->json($register, 201);
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
        $register = $this->repository->find($id);

        return response()->json($register);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  RegisterUpdateRequest $request
     * @param  string $id
     *
     * @return Response
     */
    public function update(Request $request, $id)
    {
        $register = $this->repository->skipPresenter()
            ->update($request->all(), $id);
        return response()->json($register->presenter(), 200);
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
        $this->repository->delete($id);
        return response()->json(null, 204);
    }
    public function Export()
    {
        return Excel::download(new RegistersExport, 'listregister.xlsx');
    }
    public function checkRegistered(Request $request)
    {
        $check = $this->repository->checkRegister($request->all());
        return response()->json($check);
    }
    public function unRegister(Request $request)
    {
        $un = $this->repository->delRegister($request->all());
        return $un;
    }
}
