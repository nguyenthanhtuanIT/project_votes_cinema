<?php

namespace App\Presenters;

use App\Transformers\StatisticalTransformer;
use Prettus\Repository\Presenter\FractalPresenter;

/**
 * Class StatisticalPresenter.
 *
 * @package namespace App\Presenters;
 */
class StatisticalPresenter extends FractalPresenter
{
    protected $resourceKeyItem = 'Statistical';
    protected $resourceKeyCollection = 'Statistical';
    /**
     * Transformer
     *
     * @return \League\Fractal\TransformerAbstract
     */
    public function getTransformer()
    {
        return new StatisticalTransformer();
    }
}
