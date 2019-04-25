<?php

namespace App\Http\Controllers;

use App\Http\Requests\TypeCinemaCreateRequest;
use App\Http\Requests\TypeCinemaUpdateRequest;
use App\Models\TypeCinema;
use App\Repositories\Contracts\TypeCinemaRepository;
use Illuminate\Http\Request;

/**
 * Class TypeCinemasController.
 *
 * @package namespace App\Http\Controllers;
 */
class TypeCinemasController extends Controller {
	/**
	 * @var TypeCinemaRepository
	 */
	protected $repository;

	/**
	 * TypeCinemasController constructor.
	 *
	 * @param TypeCinemaRepository $repository
	 */
	public function __construct(TypeCinemaRepository $repository) {
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

		$typeCinemas = $this->repository->paginate($limit, $columns = ['*']);

		return response()->json($typeCinemas);
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @param  TypeCinemaCreateRequest $request
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function store(TypeCinemaCreateRequest $request) {
		$typeCinema = $this->repository->skipPresenter()->create($request->all());

		return response()->json($typeCinema->presenter(), 201);
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  int $id
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function show($id) {
		$typeCinema = $this->repository->find($id);

		return response()->json($typeCinema);
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  TypeCinemaUpdateRequest $request
	 * @param  string $id
	 *
	 * @return Response
	 */
	public function update(TypeCinemaUpdateRequest $request, $id) {
		$typeCinema = $this->repository->skipPresenter()->update($request->all(), $id);

		return response()->json($typeCinema->presenter(), 200);
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
