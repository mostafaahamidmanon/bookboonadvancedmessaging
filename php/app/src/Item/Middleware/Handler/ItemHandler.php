<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace App\Item\Middleware\Handler;

use Symfony\Component\Messenger\Handler\MessageHandlerInterface;
use App\Item\Middleware\Message\Item;
use App\Item\Infrastructure\KafkaPublisher;
use App\Item\Middleware\Handler\ItemHandlerException;
use JMS\Serializer\SerializerBuilder;

/**
 * Routes between actions on item (CRUD operations)
 *
 * @author mosta <info@manonworld.de>
 */
class ItemHandler implements MessageHandlerInterface {
    
    private KafkaPublisher $publisher;
    
    public function __construct(KafkaPublisher $publisher)
    {
        $this->publisher = $publisher;
    }
    
    public function __invoke(Item $item)
    {
        try {
            
            $context = $this->publisher->createContext();

            $serializer = SerializerBuilder::create()->build();
            $serItem = $serializer->serialize($item, 'json');

            $message = $context->createMessage($serItem);
            $fooTopic = $context->createTopic('item-topic');
            $context->createProducer()->send($fooTopic, $message);
            
            echo "\nNew Message: " . $serItem . "\n";
            
            // TODO: inform the PipelineDB stream
            
        } catch (\Exception $e) {
            
            throw new ItemHandlerException($e->getMessage(), 500, $e);
            
        }
    }
    
}
