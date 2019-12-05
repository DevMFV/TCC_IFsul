<?php

namespace App\Transformers;

use League\Fractal\TransformerAbstract;
use App\Entities\Attachment;

/**
 * Class AttachmentTransformer.
 *
 * @package namespace App\Transformers;
 */
class AttachmentTransformer extends TransformerAbstract
{
    /**
     * Transform the Attachment entity.
     *
     * @param \App\Entities\Attachment $model
     *
     * @return array
     */
    public function transform(Attachment $model)
    {
        return [
            'id'         => (int) $model->id,

            /* place your other model properties here */

            'created_at' => $model->created_at,
            'updated_at' => $model->updated_at
        ];
    }
}
