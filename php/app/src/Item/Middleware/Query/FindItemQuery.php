<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace App\Item\Middleware\Query;

use App\Item\Middleware\Query\AbstractItemQuery;

/**
 * Finds an item by ID
 *
 * @author mosta <info@manonworld.de>
 */
class FindItemQuery extends AbstractItemQuery {
    
    public function find(string $id)
    {
        return $this->repo->find($id);
    }
    
}
