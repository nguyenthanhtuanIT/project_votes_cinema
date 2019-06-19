<?php

namespace App\Repositories\Eloquent;

use App\Models\Comment;
use App\Presenters\CommentPresenter;
use App\Repositories\Contracts\CommentRepository;
use DB;
use Prettus\Repository\Criteria\RequestCriteria;
use Prettus\Repository\Eloquent\BaseRepository;

/**
 * Class CommentRepositoryEloquent.
 *
 * @package namespace App\Repositories\Eloquent;
 */
class CommentRepositoryEloquent extends BaseRepository implements CommentRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return Comment::class;
    }

    /**
     * Specify Presenter class name
     *
     * @return string
     */
    public function presenter()
    {
        return CommentPresenter::class;
    }

    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }
    public function commentsByBlog($blog_id)
    {
        $com = DB::table('comments')
            ->select(
                'comments.id',
                'comments.user_id',
                'comments.content',
                'users.full_name',
                'users.avatar'
            )
            ->join(
                'users',
                'users.id', '=', 'comments.user_id'
            )->get();
        return $com;
    }
}
