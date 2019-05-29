<?php

namespace App\Presenters;

use App\Transformers\RequesterTransformer;
use Prettus\Repository\Presenter\FractalPresenter;

/**
 * Class RequesterPresenter.
 *
 * @package namespace App\Presenters;
 */
class RequesterPresenter extends FractalPresenter
{
    /**
     * Transformer
     *
     * @return \League\Fractal\TransformerAbstract
     */
    public function getTransformer()
    {
        return new RequesterTransformer();
    }
}
