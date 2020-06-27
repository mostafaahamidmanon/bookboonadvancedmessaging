<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace App\Item\Middleware\Handler\Command;

use Symfony\Component\Messenger\Handler\MessageHandlerInterface;
use App\Item\Middleware\Message\Command\UpdateItemCommand;
use App\Item\Repository\ItemRepository;
use App\Infrastructure\AppValidator;
use App\Item\Validator\ItemValidatorContraints;
use App\Infrastructure\AppSerializer;
use App\Item\Entity\Item;


/**
 * Update Item Command Handler
 *
 * @author mosta <info@manonworld.de>
 */
class UpdateItemCommandHandler implements MessageHandlerInterface {
    
    /**
     *
     * @var ItemRepository $repo
     */
    private ItemRepository $repo;
    
    /**
     *
     * @var AppValidator $validator
     */
    private AppValidator $validator;
    
    /**
     * 
     * @param ItemRepository $repo
     * @param AppValidator $validator
     */
    public function __construct(
        ItemRepository $repo, 
        AppValidator $validator
    ){
        $this->repo         = $repo;
        $this->validator    = $validator;
    }
    
    /**
     * 
     * Inserts the data after deserialization
     * 
     * @param UpdateItemCommand $command
     * @return Item
     */
    public function __invoke(UpdateItemCommand $command)
    {   
        $em = $this->repo->entityManager;
        
        $request = json_decode($command->getRequest());
        
        $item = $command->getItem();
        
        if( isset($request->item_name) ) {
            $item->setItemName($request->item_name);
        }
        
        if( isset($request->item_details) ) {
            $item->setItemDetails($request->item_details);
        }
        
        $this->validator->validate($item);

        $em->flush();
        
        return $item;
    }
    
}
