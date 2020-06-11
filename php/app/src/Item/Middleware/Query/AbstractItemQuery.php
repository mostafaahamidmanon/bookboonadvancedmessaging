<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace App\Item\Middleware\Query;

use App\Item\Repository\ItemRepository;

/**
 * Description of AbstractItemQuery
 *
 * @author mosta <info@manonworld.de>
 */
class AbstractItemQuery {
    
    /**
     *
     * @var ItemRepository $repo
     */
    protected ItemRepository $repo;
    
    /**
     * 
     * New Instance
     * 
     * @param ItemRepository $repo
     */
    public function __construct(ItemRepository $repo)
    {
        $this->repo = $repo;
    }
    
}