<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace App\Item\Repository;

use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use App\Item\Entity\Item;

/**
 * The item repository
 *
 * @author mosta <info@manonworld.de>
 */
class ItemRepository extends ServiceEntityRepository {
    
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Item::class);
    }
    
}
