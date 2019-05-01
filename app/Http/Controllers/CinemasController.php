<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Requests\CinemaCreateRequest;
use App\Http\Requests\CinemaUpdateRequest;
use App\Repositories\Contracts\CinemaRepository;

/**
 * Class CinemasController.
 *
 * @package namespace App\Http\Controllers;
 */
class CinemasController extends Controller
{
    /**
     * @var CinemaRepository
     */
    protected $repository;

    /**
     * CinemasController constructor.
     *
     * @param CinemaRepository $repository
     */
    public function __construct(CinemaRepository $repository)
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
        $limit = request()->get('limit', null);
        
        $includes = request()->get('include', '');

        if ($includes) {
            $this->repository->with(explode(',', $includes));
        }

        $this->repository->pushCriteria(app('Prettus\Repository\Criteria\RequestCriteria'));

        $cinemas = $this->repository->paginate($limit, $columns = ['*']);

        return response()->json($cinemas);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  CinemaCreateRequest $request
     *
     * @return \Illuminate\Http\Response
     */
    public function store(CinemaCreateRequest $request)
    {
        $cinema = $this->repository->skipPresenter()->create($request->all());

        return response()->json($cinema->presenter(), 201);
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
        $cinema = $this->repository->find($id);
        
        return response()->json($cinema);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  CinemaUpdateRequest $request
     * @param  string $id
     *
     * @return Response
     */
    public function update(CinemaUpdateRequest $request, $id)
    {
        $cinema = $this->repository->skipPresenter()->update($request->all(), $id);

        return response()->json($cinema->presenter(), 200);
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
}
