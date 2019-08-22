<?php

namespace App\Presenters;

use App\Transformers\TipoSolicitanteTransformer;
use Prettus\Repository\Presenter\FractalPresenter;

/**
 * Class TipoSolicitantePresenter.
 *
 * @package namespace App\Presenters;
 */
class TipoSolicitantePresenter extends FractalPresenter
{
    /**
     * Transformer
     *
     * @return \League\Fractal\TransformerAbstract
     */
    public function getTransformer()
    {
        return new TipoSolicitanteTransformer();
    }
}
