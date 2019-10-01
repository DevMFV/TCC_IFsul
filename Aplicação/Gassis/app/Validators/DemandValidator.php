<?php

namespace App\Validators;

use \Prettus\Validator\Contracts\ValidatorInterface;
use \Prettus\Validator\LaravelValidator;

/**
 * Class DemandValidator.
 *
 * @package namespace App\Validators;
 */
class DemandValidator extends LaravelValidator
{
    /**
     * Validation Rules
     *
     * @var array
     */
    protected $rules = [

        ValidatorInterface::RULE_CREATE => [
            'titulo'               => 'required',
            'data_prazo'           => 'required',
            'requester_id'         => 'required',
            'assisted_id'          => 'required'
        ],

        ValidatorInterface::RULE_UPDATE => [],
    ];
}
