<?php

namespace App\Http\Controllers;

use App\Http\Requests\TypeCinemaUserCreateRequest;
use App\Http\Requests\TypeCinemaUserUpdateRequest;
use App\Repositories\Contracts\TypeCinemaUserRepository;
use Illuminate\Http\Request;

/**
 * Class TypeCinemaUsersController.
 *
 * @package namespace App\Http\Controllers;
 */
class TypeCinemaUsersController extends Controller {
	/**
	 * @var TypeCinemaUserRepository
	 */
	protected $repository;

	/**
	 * TypeCinemaUsersController constructor.
	 *
	 * @param TypeCinemaUserRepository $repository
	 */
	public function __construct(TypeCinemaUserRepository $repository) {
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

		$typeCinemaUsers = $this->repository->paginate($limit, $columns = ['*']);

		return response()->json($typeCinemaUsers);
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @param  TypeCinemaUserCreateRequest $request
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function store(TypeCinemaUserCreateRequest $request) {
		$typeCinemaUser = $this->repository->skipPresenter()->create($request->all());

		return response()->json($typeCinemaUser->presenter(), 201);
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  int $id
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function show($id) {
		$typeCinemaUser = $this->repository->find($id);

		return response()->json($typeCinemaUser);
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  TypeCinemaUserUpdateRequest $request
	 * @param  string $id
	 *
	 * @return Response
	 */
	public function update(TypeCinemaUserUpdateRequest $request, $id) {
		$typeCinemaUser = $this->repository->skipPresenter()->update($request->all(), $id);

		return response()->json($typeCinemaUser->presenter(), 200);
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
