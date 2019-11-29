<?php

namespace App\Presenters;

use App\Transformers\CurrentStateTransformer;
use Prettus\Repository\Presenter\FractalPresenter;

/**
 * Class CurrentStatePresenter.
 *
 * @package namespace App\Presenters;
 */
class CurrentStatePresenter extends FractalPresenter
{
    /**
     * Transformer
     *
     * @return \League\Fractal\TransformerAbstract
     */
    public function getTransformer()
    {
        return new CurrentStateTransformer();
    }
}
