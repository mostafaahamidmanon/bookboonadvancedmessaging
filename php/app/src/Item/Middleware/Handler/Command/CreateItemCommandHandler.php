<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace App\Item\Middleware\Handler\Command;

use Symfony\Component\Messenger\Handler\MessageHandlerInterface;
use App\Item\Middleware\Message\Command\CreateItemCommand;
use App\Item\Repository\ItemRepository;
use App\Infrastructure\AppValidator;
use App\Item\Validator\ItemValidatorContraints;
use App\Infrastructure\AppSerializer;
use App\Item\Entity\Item;


/**
 * Create Item Command Handler
 *
 * @author mosta <info@manonworld.de>
 */
class CreateItemCommandHandler implements MessageHandlerInterface {
    
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
     * @var AppSerializer $serializer
     */
    private AppSerializer $serializer;
    
    /**
     * 
     * @param ItemRepository $repo
     * @param AppValidator $validator
     * @param AppSerializer $serializer
     */
    public function __construct(
        ItemRepository $repo, 
        AppValidator $validator,
        AppSerializer $serializer
    ){
        $this->repo         = $repo;
        $this->validator    = $validator;
        $this->serializer    = $serializer;
    }
    
    /**
     * 
     * Inserts the data after deserialization
     * 
     * @param CreateItemCommand $command
     * @return Item
     */
    public function __invoke(CreateItemCommand $command)
    {   
        $em = $this->repo->entityManager;
            
        $item = $this->serializer->deserialize($command->getRequest(), Item::class, 'json');
            
        $this->validator->validate($item);

        $em->persist($item);

        $em->flush();
        
        return $item;
    }
    
}
