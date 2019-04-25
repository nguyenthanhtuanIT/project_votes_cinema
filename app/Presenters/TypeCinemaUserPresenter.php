<?php

namespace App\Presenters;

use App\Transformers\TypeCinemaUserTransformer;
use Prettus\Repository\Presenter\FractalPresenter;

/**
 * Class TypeCinemaUserPresenter.
 *
 * @package namespace App\Presenters;
 */
class TypeCinemaUserPresenter extends FractalPresenter
{
    protected $resourceKeyItem = 'TypeCinemaUser';
    protected $resourceKeyCollection = 'TypeCinemaUser';
    /**
     * Transformer
     *
     * @return \League\Fractal\TransformerAbstract
     */
    public function getTransformer()
    {
        return new TypeCinemaUserTransformer();
    }
}
