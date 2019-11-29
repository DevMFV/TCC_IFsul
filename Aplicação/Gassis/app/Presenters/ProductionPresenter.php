<?php

namespace App\Presenters;

use App\Transformers\ProductionTransformer;
use Prettus\Repository\Presenter\FractalPresenter;

/**
 * Class ProductionPresenter.
 *
 * @package namespace App\Presenters;
 */
class ProductionPresenter extends FractalPresenter
{
    /**
     * Transformer
     *
     * @return \League\Fractal\TransformerAbstract
     */
    public function getTransformer()
    {
        return new ProductionTransformer();
    }
}
