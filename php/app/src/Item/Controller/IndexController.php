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

/**
 * The Main and Only Controller for the Test Application
 *
 * @author mosta <info@manonworld.de>
 */
class IndexController extends AbstractController 
{
    
    /**
     *
     * @var RequestStack $request
     */
    private RequestStack $request;
    
    /**
     * 
     * New Instance
     * 
     * @param RequestStack $request
     */
    public function __construct(RequestStack $request)
    {
        $this->request = $request;
    }
    
    /**
     * 
     * Lists items
     * 
     * @Route("/", methods={"GET"})
     * @return JsonResponse
     */
    public function index()
    {
        return $this->json(['index' => $this->request->getCurrentRequest()]);
    }
    
    /**
     * 
     * Adds an item
     * 
     * @Route("/", methods={"POST"})
     * @return JsonResponse
     */
    public function add()
    {
        return $this->json(['add' => $this->request->getCurrentRequest()]);
    }
    
    /**
     * 
     * Gets an item
     * 
     * @Route("/{id}", methods={"GET"})
     * @return JsonResponse
     */
    public function find(UuidInterface $id)
    {
        return $this->json(['find' => 'data']);
    }
    
    /**
     * 
     * Updates an item
     * 
     * @Route("/{id}", methods={"PUT"})
     * @return JsonResponse
     */
    public function update(UuidInterface $id)
    {
        return $this->json(['update' => $id]);
    }
    
    /**
     * 
     * Deletes an item
     * 
     * @Route("/{id}", methods={"DELETE"})
     * @return JsonResponse
     */
    public function delete(UuidInterface $id)
    {
        return $this->json(['delete' => $id]);
    }
    
}
