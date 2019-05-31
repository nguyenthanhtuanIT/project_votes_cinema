<?php

namespace App\Presenters;

use App\Transformers\ChairTransformer;
use Prettus\Repository\Presenter\FractalPresenter;

/**
 * Class ChairPresenter.
 *
 * @package namespace App\Presenters;
 */
class ChairPresenter extends FractalPresenter
{
    protected $resourceKeyItem = 'Chair';
    protected $resourceKeyCollection = 'Chair';
    /**
     * Transformer
     *
     * @return \League\Fractal\TransformerAbstract
     */
    public function getTransformer()
    {
        return new ChairTransformer();
    }
}
