<?php

namespace App\Command;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;
use App\Item\Infrastructure\KafkaClient;
use Symfony\Component\Process\Process;

/**
 * Consume Items Event
 */
class ConsumeItemsEventsCommand extends Command
{
    /**
     *
     * @var string $defaultName
     */
    protected static $defaultName = 'app:consume:items:events';
    
    /**
     *
     * @var KafkaClient $client
     */
    private KafkaClient $client;
    
    /**
     * 
     * @param KafkaClient $client
     */
    public function __construct(KafkaClient $client)
    {
        $this->client = $client;
        parent::__construct();
    }

    /**
     * Configuration of the command
     */
    protected function configure()
    {
        $this->setDescription('Consumes Items Messages from Kafka');
    }

    /**
     * 
     * Consumes the item messages in the topic
     * 
     * @param InputInterface $input
     * @param OutputInterface $output
     * @return int
     */
    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);
        
        $context = $this->client->createContext();
        
        $itemTopic = $context->createTopic('item-topic');
        
        $consumer = $context->createConsumer($itemTopic);
        
        $consumer->setCommitAsync(true);
        
        $message = $consumer->receive();
        
        $io->block($message->getBody());
        
        $consumer->acknowledge($message);
        
        $io->success('Message Acknowledged');
        
        return 0;
    }
}
