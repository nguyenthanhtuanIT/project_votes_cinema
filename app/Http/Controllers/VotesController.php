<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Requests\VoteCreateRequest;
use App\Http\Requests\VoteUpdateRequest;
use App\Repositories\Contracts\VoteRepository;

/**
 * Class VotesController.
 *
 * @package namespace App\Http\Controllers;
 */
class VotesController extends Controller
{
    /**
     * @var VoteRepository
     */
    protected $repository;

    /**
     * VotesController constructor.
     *
     * @param VoteRepository $repository
     */
    public function __construct(VoteRepository $repository)
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

        $votes = $this->repository->paginate($limit, $columns = ['*']);

        return response()->json($votes);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  VoteCreateRequest $request
     *
     * @return \Illuminate\Http\Response
     */
    public function store(VoteCreateRequest $request)
    {
        $vote = $this->repository->skipPresenter()->create($request->all());

        return response()->json($vote->presenter(), 201);
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
        $vote = $this->repository->find($id);
        
        return response()->json($vote);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  VoteUpdateRequest $request
     * @param  string $id
     *
     * @return Response
     */
    public function update(VoteUpdateRequest $request, $id)
    {
        $vote = $this->repository->skipPresenter()->update($request->all(), $id);

        return response()->json($vote->presenter(), 200);
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
