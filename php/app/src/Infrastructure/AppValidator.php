<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace App\Infrastructure;

use Symfony\Component\Validator\Validator\ValidatorInterface;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Validator\Validation;
use App\Infrastructure\ValidationException;

/**
 * Validates an object
 *
 * @author mosta <info@manonworld.de>
 */
class AppValidator {
    
    /**
     *
     * @var ValidatorInterface $validator
     */
    private ValidatorInterface $validator;
    
    /**
     *
     * @var Assert\GroupSequence $groups 
     */
    private Assert\GroupSequence $groups;
    
    /**
     * 
     * @param ValidatorInterface $validator
     */
    public function __construct(ValidatorInterface $validator)
    {
        $this->validator        = $validator;
        $this->groups           = new Assert\GroupSequence(['Default', 'custom']);
    }
    
    /**
     * 
     * Validates Data (Object or Array)
     * 
     * @param mixed $object
     * @param Assert\Collection|null $assertColl
     * @throws ValidationException
     * @return string|null
     */
    public function validate($data, ?Assert\Collection $assertColl = null): ?string
    {
        $errors = $this->validator->validate($data, $assertColl, $this->groups);
        
        if(count($errors) > 0){
            throw new ValidationException((string) $errors);
        }
        
        return null;
    }
    
}
