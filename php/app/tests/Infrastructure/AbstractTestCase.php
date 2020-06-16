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
     *
     * @var \http\Client | null $peclClient
     */
    protected static ?\http\Client $peclClient = null;
    
    /**
     *
     * @var http\Message\Body $message
     */
    protected ?\http\Message\Body $message = null;
    
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
        
        $peclClientId = random_bytes(8);
        
        self::$peclClient = new \http\Client('curl', $peclClientId);
        
        $this->faker = \Faker\Factory::create();
        
        $this->message = new \http\Message\Body();
    }
    
    /**
     * 
     * Tears down the test
     * 
     * @return void
     */
    public function tearDown(): void
    {
        
        self::$client       = null;
        self::$kernel       = null;
        $this->message      = null;
        self::$peclClient   = null;
        parent::tearDown();
    }
    
}
