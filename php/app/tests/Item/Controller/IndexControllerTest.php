<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace App\Tests\Item\Controller;

use App\Tests\Infrastructure\AbstractTestCase;
use Symfony\Component\HttpFoundation\Response;

/**
 * Description of IndexControllerTest
 *
 * @author mosta <info@manonworld.de>
 */
class IndexControllerTest extends AbstractTestCase {
    
    public function testIfResponseCodeIs200()
    {
        parent::$client->request('GET', '/');
        
        $this->assertEquals(
                Response::HTTP_OK, 
                parent::$client->getResponse()->getStatusCode()
                );
    }
    
}
