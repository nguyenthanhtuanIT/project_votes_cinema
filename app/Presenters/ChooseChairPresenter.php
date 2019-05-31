<?php

namespace App\Presenters;

use App\Transformers\ChooseChairTransformer;
use Prettus\Repository\Presenter\FractalPresenter;

/**
 * Class ChooseChairPresenter.
 *
 * @package namespace App\Presenters;
 */
class ChooseChairPresenter extends FractalPresenter
{
    protected $resourceKeyItem = 'ChooseChair';
    protected $resourceKeyCollection = 'ChooseChair';
    /**
     * Transformer
     *
     * @return \League\Fractal\TransformerAbstract
     */
    public function getTransformer()
    {
        return new ChooseChairTransformer();
    }
}
