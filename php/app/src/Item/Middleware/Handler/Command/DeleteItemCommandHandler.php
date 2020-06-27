<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace App\Item\Middleware\Handler\Command;

use Symfony\Component\Messenger\Handler\MessageHandlerInterface;
use App\Item\Middleware\Message\Command\DeleteItemCommand;
use App\Item\Repository\ItemRepository;

/**
 * Delete Item Command Handler
 *
 * @author mosta <info@manonworld.de>
 */
class DeleteItemCommandHandler implements MessageHandlerInterface
{
    /**
     *
     * @var ItemRepository $repo
     */
    private ItemRepository $repo;
    
    /**
     * 
     * @param ItemRepository $repo
     */
    public function __construct(ItemRepository $repo)
    {
        $this->repo = $repo;
    }
    
    /**
     * 
     * @param DeleteItemCommand $command
     */
    public function __invoke(DeleteItemCommand $command)
    {
        $em = $this->repo->entityManager;
        
        $em->remove($command->getItem());
        
        $em->flush();
    }
    
}
