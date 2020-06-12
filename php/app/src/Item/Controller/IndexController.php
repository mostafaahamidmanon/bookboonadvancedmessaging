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
        ItemsCommand $command
    ){
        $this->request  = $request;
        $this->command  = $command;
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
            (new Item)
                ->setAction('list')
                ->setCorrelationId(
                    \Ramsey\Uuid\Uuid::uuid4()
                )
            );
        
        return new Response($items, Response::HTTP_OK, $this->defHeaders);
    }
    
}
