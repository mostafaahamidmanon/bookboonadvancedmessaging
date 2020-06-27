<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace App\Item\Middleware\Message\Query;

use App\Infrastructure\MessageInterface;

/**
 * Find Item Query
 *
 * @author mosta <info@manonworld.de>
 */
class FindItemQuery implements MessageInterface
{
    /**
     *
     * @var string $id;
     */
    private string $id;
    
    /**
     * 
     * @param string $id
     */
    public function __construct(string $id)
    {
        $this->id = $id;
    }
    
    public function getId(): string
    {
        return $this->id;
    }
    
    public function setId(string $id): self
    {
        $this->id = $id;
        
        return $this;
    }
    
}
