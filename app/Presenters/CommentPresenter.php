<?php

namespace App\Presenters;

use App\Transformers\CommentTransformer;
use Prettus\Repository\Presenter\FractalPresenter;

/**
 * Class CommentPresenter.
 *
 * @package namespace App\Presenters;
 */
class CommentPresenter extends FractalPresenter
{
    protected $resourceKeyItem = 'Comment';
    protected $resourceKeyCollection = 'Comment';
    /**
     * Transformer
     *
     * @return \League\Fractal\TransformerAbstract
     */
    public function getTransformer()
    {
        return new CommentTransformer();
    }
}
