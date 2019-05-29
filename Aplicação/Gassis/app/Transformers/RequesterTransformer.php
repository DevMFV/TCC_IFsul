<?php

namespace App\Transformers;

use League\Fractal\TransformerAbstract;
use App\Entities\Requester;

/**
 * Class RequesterTransformer.
 *
 * @package namespace App\Transformers;
 */
class RequesterTransformer extends TransformerAbstract
{
    /**
     * Transform the Requester entity.
     *
     * @param \App\Entities\Requester $model
     *
     * @return array
     */
    public function transform(Requester $model)
    {
        return [
            'id'         => (int) $model->id,

            /* place your other model properties here */

            'created_at' => $model->created_at,
            'updated_at' => $model->updated_at
        ];
    }
}
