<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace App\Item\Middleware\Command;

use App\Item\Middleware\Query\GetItemsQuery;

/**
 * Calls for Listing Items
 *
 * @author mosta <info@manonworld.de>
 */
class ItemsCommand {
    
    /**
     *
     * @var GetItemsQuery $getItems
     */
    private GetItemsQuery $getItems;
    
    /**
     * 
     * @param GetItemsQuery $getItems
     */
    public function __construct(GetItemsQuery $getItems) {
        $this->getItems = $getItems;
    }
    
    public function create()
    {
        
    }
    
    public function getAll()
    {
        return $this->getItems->getAll();
    }
    
    public function find()
    {
        
    }
    
    public function update()
    {
        
    }
    
    public function delete()
    {
        
    }
}
