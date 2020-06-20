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
 * Deletes an item
 *
 * @author mosta <info@manonworld.de>
 */
class DeleteItemQuery extends AbstractItemQuery {
    
    public function delete(Item $item)
    {
        $this->repo->entityManager->remove($item);
        
        $this->repo->entityManager->flush();
    }
    
}
