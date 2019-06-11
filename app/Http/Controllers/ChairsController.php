<?php

namespace App\Http\Controllers;

use App\Http\Requests\ChairCreateRequest;
use App\Http\Requests\ChairUpdateRequest;
use App\Repositories\Contracts\ChairRepository;
use Illuminate\Http\Request;

/**
 * Class ChairsController.
 *
 * @package namespace App\Http\Controllers;
 */
class ChairsController extends Controller
{
    /**
     * @var ChairRepository
     */
    protected $repository;

    /**
     * ChairsController constructor.
     *
     * @param ChairRepository $repository
     */
    public function __construct(ChairRepository $repository)
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

        $chairs = $this->repository->paginate($limit, $columns = ['*']);

        return response()->json($chairs);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  ChairCreateRequest $request
     *
     * @return \Illuminate\Http\Response
     */
    public function store(ChairCreateRequest $request)
    {
        $chair = $this->repository->create($request->all());
        return $chair;
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
        $chair = $this->repository->find($id);

        return response()->json($chair);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  ChairUpdateRequest $request
     * @param  string $id
     *
     * @return Response
     */
    public function update(ChairUpdateRequest $request, $id)
    {
        $chair = $this->repository->update($request->all(), $id);

        return response()->json($chair, 200);
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
    public function getDiagramChairByVote(Request $request)
    {
        $diagram = $this->repository->diagramChairByVote($request->all());
        return $this->repository->parserResult($diagram);
    }
    public function updateStatusChair(Request $request)
    {
        $result = $this->repository->updateChairs($request->all());
        return response()->json($result);
    }

}
