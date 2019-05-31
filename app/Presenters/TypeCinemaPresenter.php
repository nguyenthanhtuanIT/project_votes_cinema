<?php

namespace App\Presenters;

use App\Transformers\TypeCinemaTransformer;
use Prettus\Repository\Presenter\FractalPresenter;

/**
 * Class TypeCinemaPresenter.
 *
 * @package namespace App\Presenters;
 */
class TypeCinemaPresenter extends FractalPresenter
{
    protected $resourceKeyItem = 'TypeCinema';
    protected $resourceKeyCollection = 'TypeCinema';
    /**
     * Transformer
     *
     * @return \League\Fractal\TransformerAbstract
     */
    public function getTransformer()
    {
        return new TypeCinemaTransformer();
    }
}
