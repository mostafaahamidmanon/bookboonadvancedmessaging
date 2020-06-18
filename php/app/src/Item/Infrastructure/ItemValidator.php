<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace App\Item\Infrastructure;

use Symfony\Component\Validator\Validator\ValidatorInterface;
use App\Item\Entity\Item;

/**
 * Validates an item
 *
 * @author mosta <info@manonworld.de>
 */
class ItemValidator {
    
    private ValidatorInterface $validator;
    
    public function __construct(ValidatorInterface $validator)
    {
        $this->validator = $validator;
    }
    
    public function validate(Item $item)
    {
        $errors = $this->validator->validate($item);
        if(count($errors) > 0){
            return (string) $errors;
        }
    }
    
}
