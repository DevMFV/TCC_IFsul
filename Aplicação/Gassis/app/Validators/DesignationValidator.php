<?php

namespace App\Validators;

use \Prettus\Validator\Contracts\ValidatorInterface;
use \Prettus\Validator\LaravelValidator;

/**
 * Class DesignationValidator.
 *
 * @package namespace App\Validators;
 */
class DesignationValidator extends LaravelValidator
{
    /**
     * Validation Rules
     *
     * @var array
     */
    protected $rules = [
        ValidatorInterface::RULE_CREATE => [
            'productor_id'  => 'required',
            'admin_id'      => 'required',
            'demand_id'     => 'required',
        ],
        ValidatorInterface::RULE_UPDATE => [],
    ];
}
