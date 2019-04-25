<?php

namespace App\Http\Controllers;

use App\Http\Requests\RegisterCreateRequest;
use App\Http\Requests\RegisterUpdateRequest;
use App\Models\Register;
use App\Repositories\Contracts\RegisterRepository;
use Illuminate\Http\Request;

/**
 * Class RegistersController.
 *
 * @package namespace App\Http\Controllers;
 */
class RegistersController extends Controller {
	/**
	 * @var RegisterRepository
	 */
	protected $repository;

	/**
	 * RegistersController constructor.
	 *
	 * @param RegisterRepository $repository
	 */
	public function __construct(RegisterRepository $repository) {
		$this->repository = $repository;
	}

	/**
	 * Display a listing of the resource.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function index() {
		$limit = request()->get('limit', null);

		$includes = request()->get('include', '');

		if ($includes) {
			$this->repository->with(explode(',', $includes));
		}

		$this->repository->pushCriteria(app('Prettus\Repository\Criteria\RequestCriteria'));

		$registers = $this->repository->paginate($limit, $columns = ['*']);

		return response()->json($registers);
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @param  RegisterCreateRequest $request
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function store(RegisterCreateRequest $request) {
		$register = $this->repository->skipPresenter()->create($request->all());

		return response()->json($register->presenter(), 201);
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  int $id
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function show($id) {
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
	public function update(RegisterUpdateRequest $request, $id) {
		$register = $this->repository->skipPresenter()->update($request->all(), $id);

		return response()->json($register->presenter(), 200);
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int $id
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function destroy($id) {
		$this->repository->delete($id);

		return response()->json(null, 204);
	}
}
