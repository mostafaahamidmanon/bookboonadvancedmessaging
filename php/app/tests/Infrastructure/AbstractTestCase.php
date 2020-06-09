<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace App\Tests\Infrastructure;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

/**
 * Description of AbstractTestCase
 *
 * @author mosta <info@manonworld.de>
 */
class AbstractTestCase extends WebTestCase {
    
    protected static $kernel;
    
    public function setUp() {
        parent::setUp();
        
        if(null === self::$container)
        {
            self::$kernel = static::bootKernel();
        }
        
    }
    
}
