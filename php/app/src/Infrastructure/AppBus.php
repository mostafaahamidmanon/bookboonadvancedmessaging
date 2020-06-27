<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace App\Infrastructure;

use Symfony\Component\Messenger\Middleware\HandleMessageMiddleware;
use Symfony\Component\Messenger\Handler\HandlersLocator;
use Symfony\Component\Messenger\Handler\MessageHandlerInterface;
use App\Infrastructure\MessageInterface;
use Symfony\Component\Messenger\Envelope;
use Symfony\Component\Messenger\MessageBus;

/**
 * Description of AppBus
 *
 * @author mosta <info@manonworld.de>
 */
class AppBus {
    
    /**
     * 
     * Dispatches a message
     * 
     * @param MessageInterface $message
     * @return Envelope
     */
    public function dispatch(MessageInterface $message, MessageHandlerInterface $handler): Envelope
    {
        $bus = new MessageBus([
            new HandleMessageMiddleware(new HandlersLocator([
                get_class($message) => [$handler],
            ]))
        ]);
        
        return $bus->dispatch($message);
    }
    
}
