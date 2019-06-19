<?php

namespace App\Repositories\Eloquent;

use App\Models\Blog;
use App\Presenters\BlogPresenter;
use App\Repositories\Contracts\BlogRepository;
use Illuminate\Support\Facades\Storage;
use Prettus\Repository\Criteria\RequestCriteria;
use Prettus\Repository\Eloquent\BaseRepository;

/**
 * Class BlogRepositoryEloquent.
 *
 * @package namespace App\Repositories\Eloquent;
 */
class BlogRepositoryEloquent extends BaseRepository implements BlogRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return Blog::class;
    }

    /**
     * Specify Presenter class name
     *
     * @return string
     */
    public function presenter()
    {
        return BlogPresenter::class;
    }

    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }
    public function create(array $attributes)
    {
        $name = $attributes['img']->store('photos');
        $link = Storage::url($name);
        $attributes['img'] = $link;
        $blog = parent::create($attributes);
        return $blog;
    }
    public function update(array $attributes, $id)
    {
        if (isset($attributes['img'])) {
            $name = $attributes['img']->store('photos');
            $link = Storage::url($name);
            $attributes['img'] = $link;
            $img = Blog::find($id);
            $imgold = $img->img;
            $nameimg = explode('/', $imgold);
            Storage::delete('/photos/' . $nameimg[5]);
        }
        $blog = parent::update($attributes, $id);
        return $blog;
    }
    public function searchBlog($key)
    {
        $blog = Blog::where('name_blog', 'LIKE', "%{$key}%")
            ->get();
        return $blog;
    }
}
