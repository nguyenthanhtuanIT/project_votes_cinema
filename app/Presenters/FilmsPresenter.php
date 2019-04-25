<?php

namespace App\Presenters;

use App\Transformers\FilmsTransformer;
use Prettus\Repository\Presenter\FractalPresenter;

/**
 * Class FilmsPresenter.
 *
 * @package namespace App\Presenters;
 */
class FilmsPresenter extends FractalPresenter
{
    protected $resourceKeyItem = 'Films';
    protected $resourceKeyCollection = 'Films';
    /**
     * Transformer
     *
     * @return \League\Fractal\TransformerAbstract
     */
    public function getTransformer()
    {
        return new FilmsTransformer();
    }
}
