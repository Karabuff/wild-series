<?php

namespace App\DataFixtures;

use App\Entity\Program;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;

class ProgramFixtures extends Fixture implements DependentFixtureInterface
{
    CONST PROGRAMS = [
        [
            'title' => 'Walking Dead',
            'synopsis' => 'Des zombies envahissent la terre',
            'category' => 'category_Horreur',
            'reference' => 'program_WalkingDead'
        ],
        [
            'title' => 'Kenshin',
            'synopsis' => 'un ancien samourai fuit sont passé',
            'category' => 'category_Animation',
            'reference' => 'program_Kenshin'
        ],
        [
            'title' => 'Breaking Bad',
            'synopsis' => 'Je crois que ca parle de drogue',
            'category' => 'category_Action',
            'reference' => 'program_BreakingBad'
        ],
        [
            'title' => 'game of thrones',
            'synopsis' => 'Tout ca pour un siege',
            'category' => 'category_Fantastique',
            'reference' => 'program_GameOfThrones'
        ],
        [
            'title' => 'courtney fox',
            'synopsis' => 'Ouai alors c\'est vieux j\'assume ! ',
            'category' => 'category_Aventure',
            'reference' => 'program_CourtneyFox'
        ]
    ];
    public function load(ObjectManager $manager)

    {
        foreach (self::PROGRAMS as $key => $programData) {
            $program = new Program();
            $program->setTitle($programData['title']);
            $program->setSynopsis($programData['synopsis']);
            $program->setCategory($this->getReference($programData['category']));
            $manager->persist($program);
            $this->addReference($programData['reference'], $program);

        }
        $manager->flush();
    }

    public function getDependencies()
    {
        return [
            CategoryFixtures::class,
        ];
    }


}
