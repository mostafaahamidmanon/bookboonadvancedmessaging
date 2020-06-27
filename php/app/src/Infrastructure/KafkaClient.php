<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace App\Infrastructure;

use Enqueue\RdKafka\RdKafkaConnectionFactory;
use Symfony\Component\DependencyInjection\ParameterBag\ContainerBagInterface;

/**
 * Connects to Kafka
 *
 * @author mosta <info@manonworld.de>
 */
class KafkaClient {
    
    private RdKafkaConnectionFactory $conn;
    
    public function __construct(ContainerBagInterface $params)
    {
        $this->conn = new RdKafkaConnectionFactory([
            'global' => [
                'group.id' => uniqid('', true),
                'metadata.broker.list' => 'kafka:9092', // TODO: move to config
                'enable.auto.commit' => 'false',
            ],
            'topic' => [
                'auto.offset.reset' => 'beginning',
            ],
        ]);
    }
    
    
    public function createContext()
    {
        $context = $this->conn->createContext();
        
        return $context;
    }
    
}
