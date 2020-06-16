<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace App\Item\Entity;

use Doctrine\ORM\Mapping as ORM;
use Ramsey\Uuid\UuidInterface;
use JMS\Serializer\Annotation as Serializer;
use Hateoas\Configuration\Annotation as Hateoas;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Item entity
 *
 * @Serializer\XmlRoot("item")
 * @Hateoas\Relation("self", href = "expr('/' ~ object.getCorrelationId())")
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
     * @Assert\Uuid
     * @property ?UuidInteface|null $correlationId
     */
    private ?UuidInterface $correlationId = null;
    
    /**
     *
     * @ORM\Column(type="string", length=255)
     * @Assert\DateTime
     * @property string|null $arrivalTime
     */
    private ?string $arrivalTimestamp = '';
    
    /**
     * 
     * @ORM\Column(type="string", length=255)
     * @Assert\Type(type={"alpha", "digit"})
     * @Assert\NotBlank
     * @Assert\Length(
     *      min = 2,
     *      max = 255,
     *      minMessage = "Item name must be at least {{ limit }} characters long",
     *      maxMessage = "Item name cannot be longer than {{ limit }} characters",
     *      allowEmptyString = false
     * )
     * @property string|null $itemName 
     */
    private ?string $itemName = '';
    
    /**
     *
     * @ORM\Column(type="text")
     * @Assert\Type("string")
     * @Assert\NotBlank
     * @Assert\Length(
     *      min = 2,
     *      max = 1048,
     *      minMessage = "Your first name must be at least {{ limit }} characters long",
     *      maxMessage = "Your first name cannot be longer than {{ limit }} characters",
     *      allowEmptyString = false
     * )
     * @property string|null $itemDetails
     */
    private ?string $itemDetails = '';
    
    public function getArrivalTimestamp(): string
    {
        return $this->arrivalTimestamp;
    }

    public function getCorrelationId(): ?UuidInterface
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

    public function setArrivalTimestamp(?string $arrivalTimestamp) 
    {
        $this->arrivalTimestamp = $arrivalTimestamp;
        return $this;
    }

    public function setCorrelationId(?UuidInterface $correlationId)
    {
        $this->correlationId = $correlationId;
        return $this;
    }

    public function setItemName(?string $itemName) 
    {
        $this->itemName = $itemName;
        return $this;
    }

    public function setItemDetails(?string $itemDetails) 
    {
        $this->itemDetails = $itemDetails;
        return $this;
    }
    
}
