<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace App\Item\Middleware\Handler\Query;

use Symfony\Component\Messenger\Handler\MessageHandlerInterface;
use App\Item\Repository\ItemRepository;
use App\Item\Middleware\Message\Query\ListItemQuery;

/**
 * List Item Query Handler
 *
 * @author mosta <info@manonworld.de>
 */
class ListItemQueryHandler implements MessageHandlerInterface {
    
    private ItemRepository $repo;
    
    public function __construct(ItemRepository $repo) 
    {
        $this->repo = $repo;
    }
    
    public function __invoke(ListItemQuery $query)
    {
        return $this->repo->findAll();
    }
    
}
