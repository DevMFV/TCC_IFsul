<?php

namespace App\Transformers;

use League\Fractal\TransformerAbstract;
use App\Entities\CurrentState;

/**
 * Class CurrentStateTransformer.
 *
 * @package namespace App\Transformers;
 */
class CurrentStateTransformer extends TransformerAbstract
{
    /**
     * Transform the CurrentState entity.
     *
     * @param \App\Entities\CurrentState $model
     *
     * @return array
     */
    public function transform(CurrentState $model)
    {
        return [
            'id'         => (int) $model->id,

            /* place your other model properties here */

            'created_at' => $model->created_at,
            'updated_at' => $model->updated_at
        ];
    }
}
