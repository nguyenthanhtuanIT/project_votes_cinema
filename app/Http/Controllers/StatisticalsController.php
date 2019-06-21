<?php

namespace App\Http\Controllers;

use App\Http\Requests\StatisticalCreateRequest;
use App\Http\Requests\StatisticalUpdateRequest;
use App\Repositories\Contracts\StatisticalRepository;
use Illuminate\Http\Request;

/**
 * Class StatisticalsController.
 *
 * @package namespace App\Http\Controllers;
 */
class StatisticalsController extends Controller
{
    /**
     * @var StatisticalRepository
     */
    protected $repository;

    /**
     * StatisticalsController constructor.
     *
     * @param StatisticalRepository $repository
     */
    public function __construct(StatisticalRepository $repository)
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

        $statisticals = $this->repository->all($columns = ['*']);

        return response()->json($statisticals);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  StatisticalCreateRequest $request
     *
     * @return \Illuminate\Http\Response
     */
    public function store(StatisticalCreateRequest $request)
    {
        $statistical = $this->repository->create($request->all());

        return response()->json($statistical, 201);
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
        $statistical = $this->repository->find($id);

        return response()->json($statistical);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  StatisticalUpdateRequest $request
     * @param  string $id
     *
     * @return Response
     */
    public function update(StatisticalUpdateRequest $request, $id)
    {
        $statistical = $this->repository->update($request->all(), $id);

        return response()->json($statistical, 200);
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
    public function getInforByVote($vote_id)
    {
        $result = $this->repository->inforByVote($vote_id);
        return response()->json($result);
    }
    public function getAmountVote($vote_id)
    {
        $result = $this->repository->amountVoteOfFilm($vote_id);
        return response()->json($result);
    }
    public function deleteAll($vote_id)
    {
        $del = $this->repository->delAll($vote_id);
        return response()->json(null, 204);
    }
    public function getInfor()
    {
        $res = $this->repository->inforAll();
        return $res;
    }
}
