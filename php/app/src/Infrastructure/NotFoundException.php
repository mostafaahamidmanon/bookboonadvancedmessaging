<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace App\Infrastructure;

/**
 * Not Found Exception
 *
 * @author mosta <info@manonworld.de>
 */
class NotFoundException extends \Exception {
    
    public function __construct() {
        parent::__construct('Not Found', 404, $previous);
    }
    
}
