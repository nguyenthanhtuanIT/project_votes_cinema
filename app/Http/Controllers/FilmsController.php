<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Requests\FilmsCreateRequest;
use App\Http\Requests\FilmsUpdateRequest;
use App\Repositories\Contracts\FilmsRepository;

/**
 * Class FilmsController.
 *
 * @package namespace App\Http\Controllers;
 */
class FilmsController extends Controller
{
    /**
     * @var FilmsRepository
     */
    protected $repository;

    /**
     * FilmsController constructor.
     *
     * @param FilmsRepository $repository
     */
    public function __construct(FilmsRepository $repository)
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

        $films = $this->repository->paginate($limit, $columns = ['*']);

        return response()->json($films);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  FilmsCreateRequest $request
     *
     * @return \Illuminate\Http\Response
     */
    public function store(FilmsCreateRequest $request)
    {
        $film = $this->repository->skipPresenter()->create($request->all());

        return response()->json($film->presenter(), 201);
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
        $film = $this->repository->find($id);
        
        return response()->json($film);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  FilmsUpdateRequest $request
     * @param  string $id
     *
     * @return Response
     */
    public function update(FilmsUpdateRequest $request, $id)
    {
        $film = $this->repository->skipPresenter()->update($request->all(), $id);

        return response()->json($film->presenter(), 200);
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
