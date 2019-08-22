<?php

namespace App\Transformers;

use League\Fractal\TransformerAbstract;
use App\Entities\TipoSolicitante;

/**
 * Class TipoSolicitanteTransformer.
 *
 * @package namespace App\Transformers;
 */
class TipoSolicitanteTransformer extends TransformerAbstract
{
    /**
     * Transform the TipoSolicitante entity.
     *
     * @param \App\Entities\TipoSolicitante $model
     *
     * @return array
     */
    public function transform(TipoSolicitante $model)
    {
        return [
            'id'         => (int) $model->id,

            /* place your other model properties here */

            'created_at' => $model->created_at,
            'updated_at' => $model->updated_at
        ];
    }
}
