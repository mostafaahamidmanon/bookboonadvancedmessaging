<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace App\Item\Middleware\Handler;

use Symfony\Component\Messenger\Handler\MessageHandlerInterface;
use App\Item\Middleware\Message\Item;
use App\Item\Infrastructure\KafkaClient;
use App\Item\Middleware\Handler\ItemHandlerException;
use JMS\Serializer\SerializerBuilder;
use App\Item\ValueObject\ItemEnqueue;

/**
 * Routes between actions on item (CRUD operations)
 *
 * @author mosta <info@manonworld.de>
 */
class ItemHandler implements MessageHandlerInterface {
    
    private KafkaClient $client;
    
    public function __construct(KafkaClient $client)
    {
        $this->client = $client;
    }
    
    public function __invoke(Item $item)
    {
        try {
            
            $context = $this->client->createContext();
            $serializer = SerializerBuilder::create()->build();
            $serItem = $serializer->serialize($item, 'json');

            $message = $context->createMessage($serItem);
            $itemTopic = $context->createTopic('item-topic');
            $context->createProducer()->send($itemTopic, $message);
            
            print $serItem . "\n";
            
        } catch (\Exception $e) {
            throw new ItemHandlerException($e->getMessage(), 500, $e);
        }
    }
    
}
