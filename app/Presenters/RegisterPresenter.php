<?php

namespace App\Presenters;

use App\Transformers\RegisterTransformer;
use Prettus\Repository\Presenter\FractalPresenter;

/**
 * Class RegisterPresenter.
 *
 * @package namespace App\Presenters;
 */
class RegisterPresenter extends FractalPresenter
{
    protected $resourceKeyItem = 'Register';
    protected $resourceKeyCollection = 'Register';
    /**
     * Transformer
     *
     * @return \League\Fractal\TransformerAbstract
     */
    public function getTransformer()
    {
        return new RegisterTransformer();
    }
}
