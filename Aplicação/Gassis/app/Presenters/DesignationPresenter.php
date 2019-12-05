<?php

namespace App\Presenters;

use App\Transformers\DesignationTransformer;
use Prettus\Repository\Presenter\FractalPresenter;

/**
 * Class DesignationPresenter.
 *
 * @package namespace App\Presenters;
 */
class DesignationPresenter extends FractalPresenter
{
    /**
     * Transformer
     *
     * @return \League\Fractal\TransformerAbstract
     */
    public function getTransformer()
    {
        return new DesignationTransformer();
    }
}
