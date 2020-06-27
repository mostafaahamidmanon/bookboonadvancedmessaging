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
 * Updates an Item
 *
 * @author mosta <info@manonworld.de>
 */
class UpdateItemCommand implements MessageInterface {
    
    /**
     *
     * @var mixed $request
     */
    private string $request;
    
    /**
     *
     * @var Item $item
     */
    private Item $item;
    
    /**
     * 
     * @param Item $item
     * @param string $request
     */
    public function __construct(Item $item, string $request)
    {
        $this->item     = $item;
        $this->request  = $request;
    }
    
    /**
     * 
     * @return mixed
     */
    public function getRequest()
    {
        return $this->request;
    }
    
    /**
     * 
     * @param mixed $request
     * @return \self
     */
    public function setRequest($request): self
    {
        $this->request = $request;
        
        return $this;
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
