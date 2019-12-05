<?php

namespace App\Presenters;

use App\Transformers\AttachmentTransformer;
use Prettus\Repository\Presenter\FractalPresenter;

/**
 * Class AttachmentPresenter.
 *
 * @package namespace App\Presenters;
 */
class AttachmentPresenter extends FractalPresenter
{
    /**
     * Transformer
     *
     * @return \League\Fractal\TransformerAbstract
     */
    public function getTransformer()
    {
        return new AttachmentTransformer();
    }
}
