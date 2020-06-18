<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace App\Item\Middleware\Command;

use App\Item\Middleware\Query\GetItemsQuery;
use App\Item\Middleware\Query\FindItemQuery;
use App\Item\Middleware\Query\UpsertItemQuery;
use App\Item\Entity\Item;

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
     * @var FindItemQuery $findItem
     */
    private FindItemQuery $findItem;
    
    /**
     *
     * @var UpsertItemQuery $upsertItem
     */
    private UpsertItemQuery $upsertItem;
    
    /**
     * 
     * @param GetItemsQuery $getItems
     */
    public function __construct(
        GetItemsQuery $getItems, 
        FindItemQuery $findItem, 
        UpsertItemQuery $upsertItem
    ) {
        $this->getItems     = $getItems;
        $this->findItem     = $findItem;
        $this->upsertItem   = $upsertItem;
    }
    
    public function upsert(Item $item)
    {
        $this->upsertItem->upsert($item);
    }
    
    public function getAll()
    {
        return $this->getItems->getAll();
    }
    
    public function find(string $id)
    {
        return $this->findItem->find($id);
    }
    
    public function delete()
    {
        
    }
}
