<?php

namespace App\Repositories\Eloquent;

use App\Models\Comment;
use App\Presenters\CommentPresenter;
use App\Repositories\Contracts\CommentRepository;
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

        $arr = array();
        $com = Comment::where('blog_id', $blog_id)->get();
        foreach ($com as $val) {
            $check = false;
            if ($val->user_id == 1) {
                $check = true;
                $arr[] = ['coment' => $val, 'check' => $check];
            } else {
                $arr[] = ['coment' => $val, 'check' => $check];
            }
        }
        return $arr;
    }
}
