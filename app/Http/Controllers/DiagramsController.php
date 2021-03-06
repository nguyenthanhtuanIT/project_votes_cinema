<?php

namespace App\Http\Controllers;

use App\Http\Requests\DiagramCreateRequest;
use App\Http\Requests\DiagramUpdateRequest;
use App\Repositories\Contracts\DiagramRepository;
use Illuminate\Http\Request;

/**
 * Class DiagramsController.
 *
 * @package namespace App\Http\Controllers;
 */
class DiagramsController extends Controller
{
    /**
     * @var DiagramRepository
     */
    protected $repository;

    /**
     * DiagramsController constructor.
     *
     * @param DiagramRepository $repository
     */
    public function __construct(DiagramRepository $repository)
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

        $diagrams = $this->repository->custom();

        return $diagrams;
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  DiagramCreateRequest $request
     *
     * @return \Illuminate\Http\Response
     */
    public function store(DiagramCreateRequest $request)
    {
        $diagram = $this->repository->skipPresenter()->create($request->all());
        return $diagram;
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
        $diagram = $this->repository->find($id);

        return response()->json($diagram);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  DiagramUpdateRequest $request
     * @param  string $id
     *
     * @return Response
     */
    public function update(DiagramUpdateRequest $request, $id)
    {
        $diagram = $this->repository->skipPresenter()->update($request->all(), $id);

        return response()->json([$diagram]);
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
    public function diagramChairByVote(Request $request)
    {
        $result = $this->repository->getDiagramChairByVote($request->vote_id);
        return response()->json($result);
    }
    public function searchByRoom(Request $request)
    {
        $result = $this->repository->searchByRoomId($request->room_id);
        return $this->repository->parserResult($result);
    }
    public function deleteAll($room_id)
    {
        $result = $this->repository->delAll($room_id);
        return response()->json(null, 204);
    }
}
