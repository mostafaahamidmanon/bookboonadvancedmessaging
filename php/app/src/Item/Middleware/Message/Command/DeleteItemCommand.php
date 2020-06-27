<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace App\Item\Middleware\Message\Command;

use App\Infrastructure\MessageInterface;
use App\Item\Entity\Item;

/**
 * Deletes an Item 
 *
 * @author mosta <info@manonworld.de>
 */
class DeleteItemCommand implements MessageInterface {
    
    /**
     *
     * @var type 
     */
    private Item $item;
    
    /**
     * 
     * @param Item $item
     */
    public function __construct(Item $item) {
        $this->item = $item;
    }
    
    /**
     * 
     * @return Item
     */
    public function getItem(): Item
    {
        return $this->item;
    }
    
    /**
     * 
     * @param Item $item
     * @return \self
     */
    public function setItem(Item $item): self
    {
        $this->item = $item;
        
        return $this;
    }
    
}
