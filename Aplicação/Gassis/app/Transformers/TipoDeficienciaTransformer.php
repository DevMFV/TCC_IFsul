<?php

namespace App\Transformers;

use League\Fractal\TransformerAbstract;
use App\Entities\TipoDeficiencia;

/**
 * Class TipoDeficienciaTransformer.
 *
 * @package namespace App\Transformers;
 */
class TipoDeficienciaTransformer extends TransformerAbstract
{
    /**
     * Transform the TipoDeficiencia entity.
     *
     * @param \App\Entities\TipoDeficiencia $model
     *
     * @return array
     */
    public function transform(TipoDeficiencia $model)
    {
        return [
            'id'         => (int) $model->id,

            /* place your other model properties here */

            'created_at' => $model->created_at,
            'updated_at' => $model->updated_at
        ];
    }
}
