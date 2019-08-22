<?php

namespace App\Validators;

use \Prettus\Validator\Contracts\ValidatorInterface;
use \Prettus\Validator\LaravelValidator;

/**
 * Class TipoSolicitanteValidator.
 *
 * @package namespace App\Validators;
 */
class TipoSolicitanteValidator extends LaravelValidator
{
    /**
     * Validation Rules
     *
     * @var array
     */
    protected $rules = [
        ValidatorInterface::RULE_CREATE => [
            'tipo'           => 'required',
        ],
        ValidatorInterface::RULE_UPDATE => [],
    ];
}
