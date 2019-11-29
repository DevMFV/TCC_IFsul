<?php

namespace App\Transformers;

use League\Fractal\TransformerAbstract;
use App\Entities\Evaluation;

/**
 * Class EvaluationTransformer.
 *
 * @package namespace App\Transformers;
 */
class EvaluationTransformer extends TransformerAbstract
{
    /**
     * Transform the Evaluation entity.
     *
     * @param \App\Entities\Evaluation $model
     *
     * @return array
     */
    public function transform(Evaluation $model)
    {
        return [
            'id'         => (int) $model->id,

            /* place your other model properties here */

            'created_at' => $model->created_at,
            'updated_at' => $model->updated_at
        ];
    }
}
