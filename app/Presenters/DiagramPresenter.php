<?php

namespace App\Presenters;

use App\Transformers\DiagramTransformer;
use Prettus\Repository\Presenter\FractalPresenter;

/**
 * Class DiagramPresenter.
 *
 * @package namespace App\Presenters;
 */
class DiagramPresenter extends FractalPresenter
{
    protected $resourceKeyItem = 'Diagram';
    protected $resourceKeyCollection = 'Diagram';
    /**
     * Transformer
     *
     * @return \League\Fractal\TransformerAbstract
     */
    public function getTransformer()
    {
        return new DiagramTransformer();
    }
}
