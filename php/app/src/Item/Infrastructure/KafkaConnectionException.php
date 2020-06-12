<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace App\Item\Infrastructure;

/**
 * Description of KafkaConnectionException
 *
 * @author mosta <info@manonworld.de>
 */
class KafkaConnectionException extends \Exception {
    
    public function __construct(string $message = "", int $code = 0, \Throwable $previous = NULL) 
    {
        parent::__construct($message, $code, $previous);
    }
    
}
