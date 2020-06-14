<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace App\Item\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RequestStack;
use Ramsey\Uuid\UuidInterface;
use Symfony\Component\Routing\Annotation\Route;
use App\Item\Middleware\Command\ItemsCommand;
use Hateoas\HateoasBuilder;
use Symfony\Component\HttpFoundation\Response;
use App\Item\Middleware\Message\Item;
use Ramsey\Uuid\Uuid;
use JMS\Serializer\SerializerBuilder;
use App\Item\Entity\Item as DBItem;

/**
 * The Main and Only Controller for the Test Application
 *
 * @author mosta <info@manonworld.de>
 */
class IndexController extends AbstractController 
{
    
    /**
     *
     * @property RequestStack $request
     */
    private RequestStack $request;
    
    /**
     *
     * @property ItemsCommand $command
     */
    private ItemsCommand $command;
    
    /**
     *
     * @property Item $item
     */
    private Item $item;
    
    /**
     *
     * @property array $defHeaders
     */
    private array $defHeaders = [
        'Content-Type' => 'application/json'
    ];
    
    
    
    /**
     * 
     * New Instance
     * 
     * @param RequestStack $request
     * @param ItemsCommand $command
     */
    public function __construct(
        RequestStack $request,
        ItemsCommand $command,
        Item $item
    ){
        $this->request  = $request;
        $this->command  = $command;
        $this->item     = $item;
        $this->hateoas  = HateoasBuilder::create()->build();
    }
    
    /**
     * 
     * Lists items
     * 
     * @Route("/", methods={"GET"})
     * @return Response
     */
    public function index()
    {
        $items = $this->hateoas->serialize($this->command->getAll(), 'json');
        
        $this->dispatchMessage(
            $this->item
                ->setAction('list')
                ->setCorrelationId(
                    Uuid::uuid4()
                )
            );
        
        return new Response($items, Response::HTTP_OK, $this->defHeaders);
    }
    
    /**
     * 
     * Finds an Item
     * 
     * @Route("/{id}", methods={"GET"})
     * @param UuidInterface $id
     */
    public function find(DBItem $item)
    {
        $this->dispatchMessage($this->item
                ->setAction('find')
                ->setCorrelationId(
                    $item->getCorrelationId()
                )
                ->setDetails($item->getItemDetails())
                ->setName($item->getItemName()));
        
        $item = $this->hateoas->serialize($item, 'json');
        
        return new Response($item, Response::HTTP_OK, $this->defHeaders);
    }
    
}
