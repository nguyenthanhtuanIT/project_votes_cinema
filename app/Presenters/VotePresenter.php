<?php

namespace App\Presenters;

use App\Transformers\VoteTransformer;
use Prettus\Repository\Presenter\FractalPresenter;

/**
 * Class VotePresenter.
 *
 * @package namespace App\Presenters;
 */
class VotePresenter extends FractalPresenter
{
    protected $resourceKeyItem = 'Vote';
    protected $resourceKeyCollection = 'Vote';
    /**
     * Transformer
     *
     * @return \League\Fractal\TransformerAbstract
     */
    public function getTransformer()
    {
        return new VoteTransformer();
    }
}
