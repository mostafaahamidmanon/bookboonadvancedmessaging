<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace App\Item\Entity;

use Doctrine\ORM\Mapping as ORM;
use Ramsey\Uuid\UuidInterface;
/**
 * Item entity
 *
 * @ORM\Entity(repositoryClass="App\Item\Repository\ItemRepository")
 * @ORM\Table(name="item")
 * 
 * @author mosta <info@manonworld.de>
 */
class Item {
    
    /**
     *
     * @ORM\Id
     * @ORM\Column(type="uuid", unique=true)
     * @ORM\GeneratedValue(strategy="CUSTOM")
     * @ORM\CustomIdGenerator(class="Ramsey\Uuid\Doctrine\UuidOrderedTimeGenerator")
     * 
     * @property UuidInteface $correlationId
     */
    private UuidInterface $correlationId;
    
    /**
     *
     * @ORM\Column(type="string", length=255)
     * @property string $arrivalTime
     */
    private string $arrivalTimestamp;
    
    /**
     * 
     * @ORM\Column(type="string", length=255)
     * @property string $itemName 
     */
    private string $itemName;
    
    /**
     *
     * @ORM\Column(type="text")
     * @property string $itemDetails
     */
    private string $itemDetails;
    
    public function getArrivalTimestamp(): string
    {
        return $this->arrivalTimestamp;
    }

    public function getCorrelationId(): UuidInterface
    {
        return $this->correlationId;
    }

    public function getItemName(): string
    {
        return $this->itemName;
    }

    public function getItemDetails(): string 
    {
        return $this->itemDetails;
    }

    public function setArrivalTimestamp(string $arrivalTimestamp) 
    {
        $this->arrivalTimestamp = $arrivalTimestamp;
        return $this;
    }

    public function setCorrelationId(UuidInterface $correlationId)
    {
        $this->correlationId = $correlationId;
        return $this;
    }

    public function setItemName(string $itemName) 
    {
        $this->itemName = $itemName;
        return $this;
    }

    public function setItemDetails(string $itemDetails) 
    {
        $this->itemDetails = $itemDetails;
        return $this;
    }
    
}
