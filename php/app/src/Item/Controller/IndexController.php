<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace App\Item\Controller;

use Hateoas\HateoasBuilder;
use OpenApi\Annotations as OA;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

use App\ { Infrastructure\AppBus, Item\Entity\Item };
use App\Item\Middleware\Message\Query\ { ListItemQuery, FindItemQuery };
use Symfony\Component\ { HttpFoundation\RequestStack, Routing\Annotation\Route };
use Symfony\Component\ { Messenger\Stamp\HandledStamp, HttpFoundation\Response };
use App\Item\Middleware\Handler\Query\ { ListItemQueryHandler, FindItemQueryHandler };
use App\Item\Middleware\Message\Command\ { CreateItemCommand, UpdateItemCommand, DeleteItemCommand};
use App\Item\Middleware\Handler\Command\ { CreateItemCommandHandler, UpdateItemCommandHandler, DeleteItemCommandHandler };

/**
 * The Main and Only Controller for the Test Application
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
     * @var ListItemQueryHandler $lstItmQryHndlr
     */
    private ListItemQueryHandler $lstItmQryHndlr;
    
    /**
     *
     * @var CreateItemCommandHandler $crtItmCmdHndlr
     */
    private CreateItemCommandHandler $crtItmCmdHndlr;
    
    /**
     *
     * @var UpdateItemCommandHandler $updtItmCmdHndlr
     */
    private UpdateItemCommandHandler $updtItmCmdHndlr;
    
    /**
     *
     * @var DeleteItemCommandHandler $delItmCmdHndlr
     */
    private DeleteItemCommandHandler $delItmCmdHndlr;
    
    /**
     *
     * @var AppBus $bus
     */
    private AppBus $bus;
    
    /**
     *
     * @property array $defErr
     */
    private array $defErr = [
        'status' => 'error'
    ];
    
    private array $defRes = [
        'status' => 'OK'
    ];
    
    /**
     * 
     * New Instance
     * 
     * @param RequestStack $request
     * @param ListItemQueryHandler $lstItmQryHndlr List Item Query Handler
     * @param FindItemQueryHandler $fndItmQryHndlr Find Item Query Handler
     * @param CreateItemCommandHandler $crtItmCmdHndlr Create Item Command Handler
     * @param UpdateItemCommandHandler $updtItmCmdHndlr Update Item Command Handler
     * @param DeleteItemCommandHandler $delItmCmdHndlr Delete Item Command Handler
     * @param AppBus $bus Default Message Bus
     */
    public function __construct(
        RequestStack $request,
        ListItemQueryHandler $lstItmQryHndlr,
        FindItemQueryHandler $fndItmQryHndlr,
        CreateItemCommandHandler $crtItmCmdHndlr,
        UpdateItemCommandHandler $updtItmCmdHndlr,
        DeleteItemCommandHandler $delItmCmdHndlr,
        AppBus $bus
    ){
        $this->request          = $request->getCurrentRequest()->getContent();
        $this->hateoas          = HateoasBuilder::create()->build();
        $this->lstItmQryHndlr   = $lstItmQryHndlr;
        $this->fndItmQryHndlr   = $fndItmQryHndlr;
        $this->crtItmCmdHndlr   = $crtItmCmdHndlr;
        $this->updtItmCmdHndlr  = $updtItmCmdHndlr;
        $this->delItmCmdHndlr   = $delItmCmdHndlr;
        $this->bus              = $bus;
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
        $envelope = $this->bus
                ->dispatch(new ListItemQuery, $this->lstItmQryHndlr);
        
        $handledStamp = $envelope->last(HandledStamp::class);
        
        return $this->returnSuccess($handledStamp->getResult(), Response::HTTP_OK);
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
    public function find(string $id)
    {
        try {
            $envelope = $this->bus
                ->dispatch(new FindItemQuery($id), $this->fndItmQryHndlr);
        } catch (\Exception $e) {
            return $this->returnError($e->getMessage(), $e->getCode());
        }
            
        $item = $envelope->last(HandledStamp::class)->getResult();
        
        return $this->returnSuccess($item, Response::HTTP_OK);
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
        try {
            $envelope = $this->bus
                ->dispatch(new CreateItemCommand($this->request), $this->crtItmCmdHndlr);
        } catch (\Exception $e) {
            return $this->returnError($e->getMessage(), $e->getCode());
        }
            
        $item = $envelope->last(HandledStamp::class)->getResult();

        return $this->returnSuccess($item, Response::HTTP_CREATED);
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
     * @param Item $item Item DB Entity
     * @Route("/{id}", methods={"PUT"})
     * @return Response
     */
    public function update(Item $item)
    {   
        try {
            $envelope = $this->bus->dispatch(new UpdateItemCommand($item, $this->request), $this->updtItmCmdHndlr);
        } catch (\Exception $e) {
            return $this->returnError($e->getmessage(), $e->getCode());
        }
        
        $handledStamp = $envelope->last(HandledStamp::class);
        
        return $this->returnSuccess($handledStamp->getResult(), Response::HTTP_ACCEPTED);
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
     * @param Item $item Item DB Entity
     * @Route("/{id}", methods={"DELETE"})
     * @return Response
     */
    public function delete(Item $item)
    {
        try {
            $envelope = $this->bus->dispatch(new DeleteItemCommand($item), $this->delItmCmdHndlr);
        } catch (\Exception $e) {
            return $this->returnError($e->getmessage(), $e->getCode());
        }
        
        return $this->json('', Response::HTTP_NO_CONTENT);
    }
    
    /**
     * 
     * Emits the validation response
     * 
     * @param string|null $message
     * @param int|null $code
     * @return Response
     */
    private function returnError(?string $message = null, ?int $code = 500)
    {
        if($message){
            $this->defErr['details'] = $message;
        }
        
        return $this->json($this->defErr, $code);
    }
    
    /**
     * 
     * Emits the success response
     * 
     * @param mixed $data
     * @param int|null $code
     * @return Response
     */
    private function returnSuccess($data, ?int $code = 200)
    {
        if(!empty($data) && $data) {
            $this->defRes['details'] = $data;
        }
        
        $res = $this->hateoas->serialize($this->defRes, 'json');
        
        $headers = ['Content-Type' => 'application/hal+json'];
        
        return new Response($res, $code, $headers);
    }
    
}
