<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Requests\ChooseChairCreateRequest;
use App\Http\Requests\ChooseChairUpdateRequest;
use App\Repositories\Contracts\ChooseChairRepository;

/**
 * Class ChooseChairsController.
 *
 * @package namespace App\Http\Controllers;
 */
class ChooseChairsController extends Controller
{
    /**
     * @var ChooseChairRepository
     */
    protected $repository;

    /**
     * ChooseChairsController constructor.
     *
     * @param ChooseChairRepository $repository
     */
    public function __construct(ChooseChairRepository $repository)
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

        $chooseChairs = $this->repository->paginate($limit, $columns = ['*']);

        return response()->json($chooseChairs);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  ChooseChairCreateRequest $request
     *
     * @return \Illuminate\Http\Response
     */
    public function store(ChooseChairCreateRequest $request)
    {
        $chooseChair = $this->repository->skipPresenter()->create($request->all());

        return response()->json($chooseChair->presenter(), 201);
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
        $chooseChair = $this->repository->find($id);
        
        return response()->json($chooseChair);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  ChooseChairUpdateRequest $request
     * @param  string $id
     *
     * @return Response
     */
    public function update(ChooseChairUpdateRequest $request, $id)
    {
        $chooseChair = $this->repository->skipPresenter()->update($request->all(), $id);

        return response()->json($chooseChair->presenter(), 200);
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
