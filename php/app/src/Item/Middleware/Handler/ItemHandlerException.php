<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace App\Item\Middleware\Handler;

/**
 * Exception is thrown when an error occurs through item message handling
 *
 * @author mosta <info@manonworld.de>
 */
class ItemHandlerException extends \Exception {
    
    /**
     * 
     * New Instance
     * 
     * @param string $message
     * @param int $code
     * @param \Throwable $previous
     */
    public function __construct(string $message = "", int $code = 0, \Throwable $previous = NULL) {
        parent::__construct($message, $code, $previous);
    }
    
}
