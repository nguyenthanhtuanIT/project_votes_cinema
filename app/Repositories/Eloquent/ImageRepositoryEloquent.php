<?php

namespace App\Repositories\Eloquent;

use App\Models\Image as MImage;
use App\Repositories\Contracts\ImageRepository;
use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use Illuminate\Support\Facades\Storage;

/**
 * Class ImageRepositoryEloquent.
 *
 * @package namespace App\Repositories\Eloquent;
 */
class ImageRepositoryEloquent extends BaseRepository implements ImageRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return MImage::class;
    }

    public function presenter()
    {
        return \App\Presenters\ImagePresenter::class;
    }

    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }

    /**
     * Override method create to save images
     * @param  array  $attributes attributes from request
     * @return object
     */
    public function create(array $attributes)
    {
        $path = $attributes['photo']->store('photos');
        list($pathName, $filename) = explode('/', $path);
        $imgThumb = \Image::make($attributes['photo'])->resize(140, 140)->save(Storage::disk('public')->path('thumbnails') . "/{$filename}");
        $attributes['pathname'] = $path;
        $attributes['filename'] = $filename;
        $attributes['name'] = $attributes['photo']->getClientOriginalName();

        $image = parent::create($attributes);

        return $image;
    }

}
