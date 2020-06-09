<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace App\Tests\Item\Middleware;

use App\Tests\Infrastructure\AbstractTestCase;
use Enqueue\AsyncEventDispatcher\AsyncListener;


/**
 * Tests if transport of Enqueue is launched
 *
 * @author mosta <info@manonworld.de>
 */
class EnqueueTransportTest extends AbstractTestCase {
    

    public function testIfEnqueueAsyncListenerIsLaunced()
    {
        $transport = parent::$kernel->getContainer()->get('enqueue.events.async_listener');
        
        $this->assertTrue($transport instanceof AsyncListener);
    }

}
