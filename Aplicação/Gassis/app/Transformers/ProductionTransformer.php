<?php

namespace App\Transformers;

use League\Fractal\TransformerAbstract;
use App\Entities\Production;

/**
 * Class ProductionTransformer.
 *
 * @package namespace App\Transformers;
 */
class ProductionTransformer extends TransformerAbstract
{
    /**
     * Transform the Production entity.
     *
     * @param \App\Entities\Production $model
     *
     * @return array
     */
    public function transform(Production $model)
    {
        return [
            'id'         => (int) $model->id,

            /* place your other model properties here */

            'created_at' => $model->created_at,
            'updated_at' => $model->updated_at
        ];
    }
}
