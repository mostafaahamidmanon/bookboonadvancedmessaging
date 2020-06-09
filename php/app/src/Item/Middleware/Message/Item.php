<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace App\Item\Middleware\Message;

use Ramsey\Uuid\UuidInterface;
use JMS\Serializer\Annotation\ {
    Type, 
    AccessorOrder,
};

/**
 * Item Message
 * 
 * @AccessorOrder("custom", custom = {"arrivalTimestamp", "id" , "correlationId", "name", "details"})
 * @author mosta <info@manonworld.de>
 */
class Item {
    
    /**
     * @Type("string") 
     * @property string $arrivalTimestamp
     */
    private string $arrivalTimestamp = '';
    
    /**
     * @Type("Ramsey\Uuid\UuidInterface")
     * @property UuidInterface | null $arrivalTimestamp
     */
    private ?UuidInterface $id = null;
    
    /**
     * @Type("Ramsey\Uuid\UuidInterface")
     * @property UuidInterface | null $correlationId
     */
    private ?UuidInterface $correlationId = null;
    
    /**
     * @Type("string") 
     * @property string $name
     */
    private string $name = '';
    
    /**
     * @Type("string") 
     * @property string $details
     */
    private string $details = '';
    
    public function getArrivalTimestamp(): string
    {
        return $this->arrivalTimestamp;
    }

    public function getId(): ?UuidInterface
    {
        return $this->id;
    }

    public function getCorrelationId(): ?UuidInterface
    {
        return $this->correlationId;
    }

    public function getName(): string 
    {
        return $this->name;
    }

    public function getDetails(): string 
    {
        return $this->details;
    }

    public function setArrivalTimestamp(string $arrivalTimestamp) 
    {
        $this->arrivalTimestamp = $arrivalTimestamp;
        return $this;
    }

    public function setId(?UuidInterface $id) 
    {
        $this->id = $id;
        return $this;
    }

    public function setCorrelationId(?UuidInterface $correlationId) 
    {
        $this->correlationId = $correlationId;
        return $this;
    }

    public function setName(string $name) 
    {
        $this->name = $name;
        return $this;
    }

    public function setDetails(string $details) 
    {
        $this->details = $details;
        return $this;
    }
    
}
