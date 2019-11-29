<?php

namespace App\Validators;

use \Prettus\Validator\Contracts\ValidatorInterface;
use \Prettus\Validator\LaravelValidator;

/**
 * Class ProductionValidator.
 *
 * @package namespace App\Validators;
 */
class ProductionValidator extends LaravelValidator
{
    /**
     * Validation Rules
     *
     * @var array
     */
    protected $rules = [
        ValidatorInterface::RULE_CREATE => [
            'fase_id'           => 'required',
            'productor_id'      => 'required',
            'demand_id'         => 'required',
        ],
        ValidatorInterface::RULE_UPDATE => [],
    ];
}
