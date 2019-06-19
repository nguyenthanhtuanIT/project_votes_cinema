<?php

namespace App\Repositories\Eloquent;

use App\Models\Comment;
use App\Presenters\CommentPresenter;
use App\Repositories\Contracts\CommentRepository;
use App\User;
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
        $com = Comment::orderBy('id', 'DESC')->where('blog_id', $blog_id)->get(['user_id', 'content']);
        $user = User::all();
        foreach ($com as $val) {
            foreach ($user as $us) {
                if ($val->user_id == $us->id) {
                    $arr[] = array('coment' => $val, 'name_user' => $us->full_name, 'avatar' => $us->avatar);
                }
            }
        }
        return $arr;
    }
}
