<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace App\Tests\Infrastructure;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

/**
 * Abstract test case
 * 
 * @property Kernel $kernel Kernel to get dependencies (DI Container)
 * @property Client $client Client for web requests
 * 
 * @method void setup() Sets up the test case and prepares the DI container alongside the web requests client
 *
 * @author mosta <info@manonworld.de>
 */
class AbstractTestCase extends WebTestCase
{
    /**
     *
     * @var Kernel
     */
    protected static $kernel;
    
    /**
     *
     * @var Client
     */
    protected static $client;
    
    /**
     * Sets up the test
     * 
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        
        self::$client = static::createClient();
        
        if(null === self::$container)
        {
            self::$kernel = static::bootKernel();
        }
    }
    
    /**
     * 
     * Tears down the test
     * 
     * @return void
     */
    public function tearDown(): void
    {
        
        self::$client = null;
        self::$kernel = null;
        
        parent::tearDown();
    }
    
}
