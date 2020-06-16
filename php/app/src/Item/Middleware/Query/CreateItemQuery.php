<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace App\Item\Middleware\Query;

use App\Item\Middleware\Query\AbstractItemQuery;
use App\Item\Entity\Item;

/**
 * Creates an item
 *
 * @author mosta <info@manonworld.de>
 */
class CreateItemQuery extends AbstractItemQuery {
    
    public function create(Item $item): Item
    {
        $this->repo->entityManager->persist($item);
        $this->repo->entityManager->flush();
        
        return $item;
    }
    
}
