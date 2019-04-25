<?php

namespace App\Presenters;

use App\Transformers\VoteDetailsTransformer;
use Prettus\Repository\Presenter\FractalPresenter;

/**
 * Class VoteDetailsPresenter.
 *
 * @package namespace App\Presenters;
 */
class VoteDetailsPresenter extends FractalPresenter
{
    protected $resourceKeyItem = 'VoteDetails';
    protected $resourceKeyCollection = 'VoteDetails';
    /**
     * Transformer
     *
     * @return \League\Fractal\TransformerAbstract
     */
    public function getTransformer()
    {
        return new VoteDetailsTransformer();
    }
}
