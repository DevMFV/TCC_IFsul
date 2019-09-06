<?php

namespace App\Transformers;

use League\Fractal\TransformerAbstract;
use App\Entities\Demand;

/**
 * Class DemandTransformer.
 *
 * @package namespace App\Transformers;
 */
class DemandTransformer extends TransformerAbstract
{
    /**
     * Transform the Demand entity.
     *
     * @param \App\Entities\Demand $model
     *
     * @return array
     */
    public function transform(Demand $model)
    {
        return [
            'id'         => (int) $model->id,

            /* place your other model properties here */

            'created_at' => $model->created_at,
            'updated_at' => $model->updated_at
        ];
    }
}
