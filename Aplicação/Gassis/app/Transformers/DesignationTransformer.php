<?php

namespace App\Transformers;

use League\Fractal\TransformerAbstract;
use App\Entities\Designation;

/**
 * Class DesignationTransformer.
 *
 * @package namespace App\Transformers;
 */
class DesignationTransformer extends TransformerAbstract
{
    /**
     * Transform the Designation entity.
     *
     * @param \App\Entities\Designation $model
     *
     * @return array
     */
    public function transform(Designation $model)
    {
        return [
            'id'         => (int) $model->id,

            /* place your other model properties here */

            'created_at' => $model->created_at,
            'updated_at' => $model->updated_at
        ];
    }
}
