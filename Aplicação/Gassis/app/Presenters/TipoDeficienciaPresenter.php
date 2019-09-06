<?php

namespace App\Presenters;

use App\Transformers\TipoDeficienciaTransformer;
use Prettus\Repository\Presenter\FractalPresenter;

/**
 * Class TipoDeficienciaPresenter.
 *
 * @package namespace App\Presenters;
 */
class TipoDeficienciaPresenter extends FractalPresenter
{
    /**
     * Transformer
     *
     * @return \League\Fractal\TransformerAbstract
     */
    public function getTransformer()
    {
        return new TipoDeficienciaTransformer();
    }
}
