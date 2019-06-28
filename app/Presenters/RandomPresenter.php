<?php

namespace App\Presenters;

use App\Transformers\RandomTransformer;
use Prettus\Repository\Presenter\FractalPresenter;

/**
 * Class RandomPresenter.
 *
 * @package namespace App\Presenters;
 */
class RandomPresenter extends FractalPresenter
{
    protected $resourceKeyItem = 'Random';
    protected $resourceKeyCollection = 'Random';
    /**
     * Transformer
     *
     * @return \League\Fractal\TransformerAbstract
     */
    public function getTransformer()
    {
        return new RandomTransformer();
    }
}
