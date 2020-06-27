<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace App\Item\Validator;

use Symfony\Component\Validator\Constraints as Assert;

/**
 * Description of ItemValidatorContraints
 *
 * @author mosta <info@manonworld.de>
 */
class ItemValidatorContraints {
    
    /**
     * 
     * @return Assert\Collection
     */
    public function getConstraints(): Assert\Collection
    {
        return new Assert\Collection([
            'id' => new Assert\Optional([
                new Assert\Uuid,
                new Assert\NotBlank
            ]),
            'item_name' => new Assert\Optional([
                new Assert\Type(['alpha', 'digit']),
                new Assert\NotBlank,
                new Assert\Length([
                    'min' => 2,
                    'max' => 255,
                    'minMessage' => "Item name must be at least {{ limit }} characters long",
                    'maxMessage' => "Item name cannot be longer than {{ limit }} characters",
                    'allowEmptyString' => false
                ])
            ]),
            'item_details' => new Assert\Optional([
                new Assert\Type("string"),
                new Assert\NotBlank,
                new Assert\Length([
                    'min' => 2,
                    'max' => 1048,
                    'minMessage' => "Item details must be at least {{ limit }} characters long",
                    'maxMessage' => "Item details cannot be longer than {{ limit }} characters",
                    'allowEmptyString' => false
                ])
            ])
        ]);
    }
    
}
