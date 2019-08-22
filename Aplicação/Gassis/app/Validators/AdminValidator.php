<?php

namespace App\Validators;

use \Prettus\Validator\Contracts\ValidatorInterface;
use \Prettus\Validator\LaravelValidator;

/**
 * Class AdminValidator.
 *
 * @package namespace App\Validators;
 */
class AdminValidator extends LaravelValidator
{
    /**
     * Validation Rules
     *
     * @var array
     */
    protected $rules = [
        ValidatorInterface::RULE_CREATE => [
            'name'           => 'required',
            'email'          => 'required',
        ],
        ValidatorInterface::RULE_UPDATE => [],
    ];
}
