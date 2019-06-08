<?php

namespace App\Http\Controllers;

use App\Http\Requests\VoteDetailsCreateRequest;
use App\Http\Requests\VoteDetailsUpdateRequest;
use App\Repositories\Contracts\VoteDetailsRepository;
use Illuminate\Http\Request;

/**
 * Class VoteDetailsController.
 *
 * @package namespace App\Http\Controllers;
 */
class VoteDetailsController extends Controller
{
    /**
     * @var VoteDetailsRepository
     */
    protected $repository;

    /**
     * VoteDetailsController constructor.
     *
     * @param VoteDetailsRepository $repository
     */
    public function __construct(VoteDetailsRepository $repository)
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

        $voteDetails = $this->repository->paginate($limit, $columns = ['*']);

        return response()->json($voteDetails);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  VoteDetailsCreateRequest $request
     *
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $voteDetail = $this->repository->create($request->all());

        return response()->json($voteDetail, 201);
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
        $voteDetail = $this->repository->find($id);

        return response()->json($voteDetail);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  VoteDetailsUpdateRequest $request
     * @param  string $id
     *
     * @return Response
     */
    public function update(VoteDetailsUpdateRequest $request, $id)
    {
        $voteDetail = $this->repository->skipPresenter()->update($request->all(), $id);

        return response()->json($voteDetail->presenter(), 200);
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
    public function checkVoted(Request $request)
    {
        $check = $this->repository->checkVotes($request->all());
        return response()->json($check);
    }
}
