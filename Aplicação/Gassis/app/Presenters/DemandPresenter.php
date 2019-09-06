<?php

namespace App\Presenters;

use App\Transformers\DemandTransformer;
use Prettus\Repository\Presenter\FractalPresenter;

/**
 * Class DemandPresenter.
 *
 * @package namespace App\Presenters;
 */
class DemandPresenter extends FractalPresenter
{
    /**
     * Transformer
     *
     * @return \League\Fractal\TransformerAbstract
     */
    public function getTransformer()
    {
        return new DemandTransformer();
    }
}
