<?php

namespace App\Validators;

use \Prettus\Validator\Contracts\ValidatorInterface;
use \Prettus\Validator\LaravelValidator;

/**
 * Class EvaluationValidator.
 *
 * @package namespace App\Validators;
 */
class EvaluationValidator extends LaravelValidator
{
    /**
     * Validation Rules
     *
     * @var array
     */
    protected $rules = [
        ValidatorInterface::RULE_CREATE => [
            'production_id' =>'required',
            'assisted_id'   =>'required'
        ],
        ValidatorInterface::RULE_UPDATE => [],
    ];
}
