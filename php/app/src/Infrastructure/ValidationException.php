<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace App\Infrastructure;

/**
 * Description of ValidationException
 *
 * @author mosta <info@manonworld.de>
 */
class ValidationException extends \Exception {
    
    public function __construct(string $message = "", int $code = 422, \Throwable $previous = NULL)
    {
        parent::__construct($message, $code, $previous);
    }
    
}
