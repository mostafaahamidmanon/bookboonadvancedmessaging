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
use App\Item\Infrastructure\AppSerializer;
use App\Item\Infrastructure\ItemValidator;
use OpenApi\Annotations as OA;

/**
 * The Main and Only Controller for the Test Application
 * 
 * @Route("/v1.0.0")
 * 
 * @OA\Info(
 *      title="BookBoon.com Advanced Messaging Using PHP7 and Symfony5",
 *      version="1.0.0",
 *      @OA\Contact(
 *          email="info@manonworld.de"
 *      )
 * )
 *
 * @author mosta <info@manonworld.de>
 */
class IndexController extends AbstractController 
{
    
    /**
     *
     * @property string $request
     */
    private string $request;
    
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
     * @var AppSerializer $serializer
     */
    private AppSerializer $serializer;
    
    /**
     *
     * @var ItemValidator $validator
     */
    private ItemValidator $validator;
    
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
     * @param AppSerializer $serializer Application Serializer
     * @param ItemValidator $validator Item Validator
     */
    public function __construct(
        RequestStack $request,
        ItemsCommand $command,
        Item $item,
        AppSerializer $serializer,
        ItemValidator $validator
    ){
        $this->request          = $request->getCurrentRequest()->getContent();
        $this->command          = $command;
        $this->item             = $item;
        $this->hateoas          = HateoasBuilder::create()->build();
        $this->serializer       = $serializer;
        $this->validator        = $validator;
    }
    
    /**
     * 
     * Lists items
     * 
     * @OA\Get(
     *      path="/",
     *      @OA\Response(
     *          response="200", 
     *          description="Listing of items",
     *          @OA\MediaType(
     *              mediaType="application/json",
     *              @OA\Schema(ref="#/components/schemas/Item")
     *          )
     *      )
     * )
     * 
     * @Route("/", methods={"GET"})
     * @return Response
     */
    public function index()
    {
        $items = $this->hateoas->serialize($this->command->getAll(), 'json');
        
        $this->dispatchMessage($this->item->setAction('list')->setCorrelationId(Uuid::uuid4()));
        
        return new Response($items, Response::HTTP_OK, $this->defHeaders);
    }
    
    /**
     * 
     * Finds an Item
     * 
     * @OA\Get(
     *      path="/{id}",
     *      @OA\Response(
     *          response="200", 
     *          description="Finds an item",
     *          @OA\MediaType(
     *              mediaType="application/json",
     *              @OA\Schema(ref="#/components/schemas/Item")
     *          )
     *      )
     * )
     * 
     * @Route("/{id}", methods={"GET"})
     * @param UuidInterface $id
     * @return Response
     */
    public function find(DBItem $item)
    {
        $this->dispatchMessage($this->item->setAction('find')
                ->setCorrelationId($item
                ->getCorrelationId())
                ->setDetails($item->getItemDetails())
                ->setName($item->getItemName()));
        
        $item = $this->hateoas->serialize($item, 'json');
        
        return new Response($item, Response::HTTP_OK, $this->defHeaders);
    }
    
    /**
     * 
     * Creates a new Item
     * 
     * @OA\Post(
     *      path="/",
     *      @OA\Response(
     *          response="201", 
     *          description="Creates a new item",
     *          @OA\MediaType(
     *              mediaType="application/json",
     *              @OA\Schema(ref="#/components/schemas/Item")
     *          )
     *      )
     * )
     * 
     * @Route("/", methods={"POST"})
     * @return Response
     */
    public function create()
    {   
        $item = $this->serializer->getSerializer()->deserialize($this->request, DBItem::class, 'json');
        
        $errors = $this->validator->validate($item);
        if($errors){
            return $this->returnValidationResponse($errors);
        }
        
        $this->command->upsert($item);
        
        $message = $this->item->setAction('create')->setName($item->getItemName())->setDetails($item->getItemDetails());
        $this->dispatchMessage($message);
        
        return new Response($this->hateoas->serialize($item, 'json'), Response::HTTP_CREATED, $this->defHeaders);
    }
    
    /**
     * 
     * Updates an Item
     * 
     * @OA\Put(
     *      path="/{id}",
     *      @OA\Response(
     *          response="202", 
     *          description="Updates an item",
     *          @OA\MediaType(
     *              mediaType="application/json",
     *              @OA\Schema(ref="#/components/schemas/Item")
     *          )
     *      )
     * )
     * 
     * @param DBItem $item Item DB Entity
     * @Route("/{id}", methods={"PUT"})
     * @return Response
     */
    public function update(DBItem $item)
    {
        $newItem = $this->serializer->getSerializer()->deserialize($this->request, DBItem::class, 'json');
        
        $newItem->setCorrelationId($item->getCorrelationId());
        
        $errors = $this->validator->validate($newItem);
        if($errors){
            return $this->returnValidationResponse($errors);
        }
        
        $this->command->upsert($newItem);
        
        $message = $this->item->setAction('update')->setName($newItem->getItemName())->setDetails($newItem->getItemDetails());
        $this->dispatchMessage($message);
        
        return new Response($this->hateoas->serialize($newItem, 'json'), Response::HTTP_ACCEPTED, $this->defHeaders);
    }
    
    /**
     * 
     * Deletes an Item
     * 
     * @OA\Delete(
     *      path="/{id}",
     *      @OA\Response(
     *          response="204", 
     *          description="Deletes an item",
     *          @OA\MediaType(
     *              mediaType="application/json",
     *              @OA\Schema(ref="#/components/schemas/Item")
     *          )
     *      )
     * )
     * 
     * @param DBItem $item Item DB Entity
     * @Route("/{id}", methods={"DELETE"})
     * @return Response
     */
    public function delete(DBItem $item)
    {
        $this->command->delete($item);
        
        $message = $this->item->setAction('delete')
                ->setName($item->getItemName())
                ->setDetails($item->getItemDetails());
        
        $this->dispatchMessage($message);
        
        return new Response('', Response::HTTP_NO_CONTENT, $this->defHeaders);
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
