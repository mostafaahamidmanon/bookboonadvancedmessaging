<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace App\Item\Middleware\Query;

use App\Item\Repository\ItemRepository;
use App\Item\Middleware\Query\QueryInterface;

/**
 * Description of AbstractItemQuery
 *
 * @author mosta <info@manonworld.de>
 */
class AbstractItemQuery implements QueryInterface {
    
    /**
     *
     * @var ItemRepository | null $repo
     */
    protected ?ItemRepository $repo = null;
    
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
