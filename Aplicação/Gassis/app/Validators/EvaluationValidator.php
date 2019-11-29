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
            'production_id',
            'assisted_id'
        ],
        ValidatorInterface::RULE_UPDATE => [],
    ];
}
