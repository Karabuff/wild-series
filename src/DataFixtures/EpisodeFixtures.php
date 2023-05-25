<?php

namespace App\DataFixtures;

use App\Entity\Episode;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;

class EpisodeFixtures extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager): void
    {
        $episode = new Episode();
        $episode->setTitle('chute libre');
        $episode->setNumber(1);
        $episode->setSeason($this->getReference('season1_BreakingBad'));
        $episode->setSynopsis('Atteint d\'un cancer du poumon en phase terminale, un prof de chimie se lance dans la fabrication et la vente de méthamphétamines pour assurer l\'avenir financier de sa famille.');
        $manager->persist($episode);

        $episode2 = new Episode();
        $episode2->setTitle('Le choix');
        $episode2->setNumber(2);
        $episode2->setSeason($this->getReference('season1_BreakingBad'));
        $episode2->setSynopsis('Alors qu\'ils viennent de rater un deal, Walt et Jesse doivent se débarrasser de deux corps, tandis que Skyler soupçonne son mari de mijoter quelque chose.');

        $manager->persist($episode2);

        $episode3 = new Episode();
        $episode3->setTitle('Dérapage');
        $episode3->setNumber(3);
        $episode3->setSeason($this->getReference('season1_BreakingBad'));
        $episode3->setSynopsis('Walter n\'a toujours pas effectué sa part du marché conclu avec Jesse qui le presse d\'en finir. Il tergiverse et hésite à commettre un acte qui pourrait le hanter toute sa vie et mettre sa famille en danger.
');
        $manager->persist($episode3);

        $manager->flush();
    }
    public function getDependencies()
    {
        return [
            SeasonFixtures::class,
        ];
    }
}
