<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace App\Item\Middleware\Message\Command;

use App\Infrastructure\MessageInterface;

/**
 * Creates an Item
 *
 * @author mosta <info@manonworld.de>
 */
class CreateItemCommand implements MessageInterface {
    
    /**
     *
     * @var string $request
     */
    private string $request;
    
    /**
     * 
     * @param mixed $request
     */
    public function __construct($request)
    {
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
    
}
