<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace App\Item\Middleware;

use Symfony\Component\Messenger\Middleware\MiddlewareInterface;
use Symfony\Component\Messenger\Handler\HandlersLocator;
use Symfony\Component\Messenger\Middleware\HandleMessageMiddleware;
use Symfony\Component\Messenger\MessageBus;
use App\Item\Middleware\Message\Item;

/**
 * Item Message Bus
 *
 * @author mosta <info@manonworld.de>
 */
class ItemBus {
    
    /**
     *
     * @var MessageBus $bus
     */
    private MessageBus $bus;

    /**
     * 
     * @param MiddlewareInterface $handler
     */
    public function __construct(MiddlewareInterface $handler, string $message) {
        $this->bus = new MessageBus([
            new HandleMessageMiddleware(new HandlersLocator([
                $message => [$handler],
            ])),
        ]);
    }
    
    /**
     * 
     * Dispatches the message
     * 
     * @param Item $message
     * @param array $stamps
     */
    public function dispatch(Item $message, array $stamps)
    {
        $this->bus->dispatch($message, $stamps);
    }

}
