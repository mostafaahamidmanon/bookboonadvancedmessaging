<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace App\Item\Middleware\Handler\Query;

use Symfony\Component\Messenger\Handler\MessageHandlerInterface;
use App\Item\Middleware\Message\Query\FindItemQuery;
use App\Item\Repository\ItemRepository;
use Symfony\Component\Validator\Validator\ValidatorInterface;
use App\Item\Validator\ItemValidatorContraints;
use App\Infrastructure\ValidationException;
use App\Infrastructure\NotFoundException;

/**
 * Find Item Query Handler
 *
 * @author mosta <info@manonworld.de>
 */
class FindItemQueryHandler implements MessageHandlerInterface {
    
    private ItemRepository $repo;
    private ValidatorInterface $validator;
    private ItemValidatorContraints $consts;
    
    public function __construct(
        ItemRepository $repo, 
        ValidatorInterface $validator, 
        ItemValidatorContraints $consts
    ){
        $this->repo         = $repo;
        $this->validator    = $validator;
        $this->consts       = $consts;
    }
    
    public function __invoke(FindItemQuery $query)
    {
        $id = ['id' => $query->getId()];
        
        if( count( $this->validator->validate($id, $this->consts->getConstraints()) )  > 0 ) {
            throw new ValidationException('Invalid Request');
        }
        
        $item = $this->repo->find($query->getId());
        
        if( !$item ) {
            throw new NotFoundException;
        }
        
        return $item;
    }
    
}
