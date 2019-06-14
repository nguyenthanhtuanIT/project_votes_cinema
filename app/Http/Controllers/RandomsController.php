<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Requests\RandomCreateRequest;
use App\Http\Requests\RandomUpdateRequest;
use App\Repositories\Contracts\RandomRepository;

/**
 * Class RandomsController.
 *
 * @package namespace App\Http\Controllers;
 */
class RandomsController extends Controller
{
    /**
     * @var RandomRepository
     */
    protected $repository;

    /**
     * RandomsController constructor.
     *
     * @param RandomRepository $repository
     */
    public function __construct(RandomRepository $repository)
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

        $randoms = $this->repository->paginate($limit, $columns = ['*']);

        return response()->json($randoms);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  RandomCreateRequest $request
     *
     * @return \Illuminate\Http\Response
     */
    public function store(RandomCreateRequest $request)
    {
        $random = $this->repository->skipPresenter()->create($request->all());

        return response()->json($random->presenter(), 201);
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
        $random = $this->repository->find($id);
        
        return response()->json($random);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  RandomUpdateRequest $request
     * @param  string $id
     *
     * @return Response
     */
    public function update(RandomUpdateRequest $request, $id)
    {
        $random = $this->repository->skipPresenter()->update($request->all(), $id);

        return response()->json($random->presenter(), 200);
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
