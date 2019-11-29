<?php

namespace App\Presenters;

use App\Transformers\EvaluationTransformer;
use Prettus\Repository\Presenter\FractalPresenter;

/**
 * Class EvaluationPresenter.
 *
 * @package namespace App\Presenters;
 */
class EvaluationPresenter extends FractalPresenter
{
    /**
     * Transformer
     *
     * @return \League\Fractal\TransformerAbstract
     */
    public function getTransformer()
    {
        return new EvaluationTransformer();
    }
}
