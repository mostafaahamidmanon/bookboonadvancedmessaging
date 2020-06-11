<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use App\Item\Entity\Item;
use Doctrine\Bundle\FixturesBundle\FixtureGroupInterface;
use Faker\Factory;
use Ramsey\Uuid\Uuid;
use Symfony\Component\Console\Command\Command;

class ItemsFixtures extends Fixture implements FixtureGroupInterface
{
    
    private ?\Faker\Generator $faker = null;
    
    public function __construct()
    {
        $this->faker    = Factory::create();
    }
    
    
    public function load(ObjectManager $manager)
    {
        $i = 0;
        
        while($i < 100):
            
            $item = (new Item)
                
                ->setArrivalTimestamp(
                    (new \DateTime)->format('Y-m-d H:i:s')
                )
                
                ->setCorrelationId(Uuid::uuid4())
                
                ->setItemName($this->faker->word)
                
                ->setItemDetails(
                    $this->faker->sentence(4, true)
                );

            $manager->persist($item);
            
            echo "- ";
            
            $i++;
            
        endwhile;
        
        $manager->flush();
        
        echo "\nDone Loading Items...\n";
        
        return Command::SUCCESS;
    }
    
    /**
     * 
     * Add dependencies when needed
     * 
     * @return type
     */
    public function getDependencies()
    {
        return [];
    }
    
    /**
     * 
     * Assigns the fixture a group
     * 
     * @return array
     */
    public static function getGroups(): array
    {
        return ['item'];
    } 
}
