<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Storage;
use App\Http\Requests\ImageCreateRequest;
use App\Repositories\Contracts\ImageRepository;

/**
 * Class ImagesController.
 *
 * @package namespace App\Http\Controllers;
 */
class ImagesController extends Controller
{
    /**
     * @var ImageRepository
     */
    protected $repository;
    /**
     * ImagesController constructor.
     *
     * @param ImageRepository $repository
     */
    public function __construct(ImageRepository $repository)
    {
        $this->repository = $repository;
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  ImageCreateRequest $request
     *
     * @return \Illuminate\Http\Response
     */
    public function store(ImageCreateRequest $request)
    {
        $image = $this->repository->skipPresenter()->create($request->all());

        return $this->presenterPostJson($image);
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
        $item = $this->repository->skipPresenter()->find($id);
        $item->delete();

        Storage::delete($item->pathname);
        Storage::delete('thumbnails/' . $item->filename);

        return response()->json(null, 204);

    }
}
