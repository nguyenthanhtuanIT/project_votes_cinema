<?php

namespace App\Http\Controllers;

use App\Http\Requests\CommentCreateRequest;
use App\Http\Requests\CommentUpdateRequest;
use App\Repositories\Contracts\CommentRepository;
use Illuminate\Http\Request;

/**
 * Class CommentsController.
 *
 * @package namespace App\Http\Controllers;
 */
class CommentsController extends Controller
{
    /**
     * @var CommentRepository
     */
    protected $repository;

    /**
     * CommentsController constructor.
     *
     * @param CommentRepository $repository
     */
    public function __construct(CommentRepository $repository)
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

        $comments = $this->repository->paginate($limit, $columns = ['*']);

        return response()->json($comments);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  CommentCreateRequest $request
     *
     * @return \Illuminate\Http\Response
     */
    public function store(CommentCreateRequest $request)
    {
        $comment = $this->repository->skipPresenter()->create($request->all());

        return response()->json($comment->presenter(), 201);
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
        $comment = $this->repository->find($id);

        return response()->json($comment);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  CommentUpdateRequest $request
     * @param  string $id
     *
     * @return Response
     */
    public function update(CommentUpdateRequest $request, $id)
    {
        $comment = $this->repository->skipPresenter()->update($request->all(), $id);

        return response()->json($comment->presenter(), 200);
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
    public function getComments($blog_id)
    {
        $res = $this->repository->commentsByBlog($blog_id);
        return response()->json($res);
        //return $this->repository->parserResult($res);
        // //$emp_collection = collect($res);
        //return $res;

    }
}
