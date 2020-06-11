<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace App\Item\Middleware\Query;

use App\Item\Middleware\Query\AbstractItemQuery;

/**
 * Description of GetItemsQuery
 *
 * @author mosta <info@manonworld.de>
 */
class GetItemsQuery extends AbstractItemQuery {
    
    public function getAll()
    {
        return $this->repo->findAll();
    }
    
}
