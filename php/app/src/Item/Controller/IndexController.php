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
use Symfony\Component\Validator\Validator\ValidatorInterface;

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
     * @property array $defValidationErr
     */
    private array $defValidationErr = [
        'status' => 'error',
        'details' => 'request error'
    ];
    
    
    
    /**
     * 
     * New Instance
     * 
     * @param RequestStack $request
     * @param ItemsCommand $command
     * @param Item $item
     */
    public function __construct(
        RequestStack $request,
        ItemsCommand $command,
        Item $item
    ){
        $this->request      = $request;
        $this->command      = $command;
        $this->item         = $item;
        $this->hateoas      = HateoasBuilder::create()->build();
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
     * @return Response
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
    
    /**
     * 
     * Creates a new Item
     * 
     * @Route("/", methods={"POST"})
     * @return Response
     */
    public function create(ValidatorInterface $validator)
    {
        $req = $this->request->getCurrentRequest()->getContent();
        
        $requestData = json_decode($req);
        if(!(json_last_error() == JSON_ERROR_NONE)){
            return $this->returnValidationResponse();
        }
        
        $item = (new DBItem)
                ->setItemName($requestData->name)
                ->setItemDetails($requestData->details);
        
        $errors = $validator->validate($item);
        if(count($errors) > 0){
            return $this->returnValidationResponse((string) $errors);
        }
        
        $this->command->create($item);
        
        $this->dispatchMessage(
                $this->item->setAction('create')
                    ->setName($item->getItemName())
                    ->setDetails($item->getItemDetails())
                );
        
        return new Response(
                $this->hateoas->serialize($item, 'json'), 
                Response::HTTP_CREATED, $this->defHeaders
                );
    }
    
    /**
     * 
     * Emits the validation response
     * 
     * @param string|null $message
     * @return Response
     */
    private function returnValidationResponse(?string $message = null)
    {
        $message ? $validationErr = $message : $validationErr = json_encode($this->defValidationErr);
        
        $validationErrCode = Response::HTTP_UNPROCESSABLE_ENTITY;
        
        return new Response($validationErr, $validationErrCode, $this->defHeaders);
    }
    
}
