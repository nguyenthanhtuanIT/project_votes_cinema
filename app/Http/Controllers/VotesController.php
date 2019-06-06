<?php

namespace App\Http\Controllers;

use App\Http\Requests\VoteCreateRequest;
use App\Http\Requests\VoteUpdateRequest;
use App\Models\Vote;
use App\Repositories\Contracts\VoteRepository;
use Illuminate\Http\Request;

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
        $vote = $this->repository->all($colums = ['*']);
        return response()->json($vote);
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
        $vote = $this->repository->update($request->all(), $id);
        return response()->json($vote, 201);
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
    public function searchByTitle(Request $request)
    {
        $result = $this->repository->search($request->title);
        return response()->json($result);
    }
    public function showStatusVote()
    {
        $vote = $this->repository->getStatus();
        return response()->json($vote);

    }
}
