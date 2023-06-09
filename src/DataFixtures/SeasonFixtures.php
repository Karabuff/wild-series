<?php

namespace App\DataFixtures;

use Faker\Factory;
use App\Entity\Season;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;

class SeasonFixtures extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager): void
    {
        $faker = Factory::create();

        for($i=0; $i<50; $i++){
            $season=new season();
            $season->setNumber($faker->numberBetween(1,10));
            $season->setYear($faker->year());
            $season->setDescription($faker->paragraph(3,true));
            $season->setProgram($this->getReference('program_' . ($i % 5+1)));
            $this->setReference('season_' . ($i % 25+1), $season);
            $manager->persist($season);
            
        }
        $manager->flush();    

    
    }
    public function getDependencies()
    {
        return [
            ProgramFixtures::class,
        ];
    }
}
