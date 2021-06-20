<?php

namespace App\DataFixtures;

use App\Entity\Season;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;

class SeasonFixtures extends Fixture implements DependentFixtureInterface
{
    /* Ajout d'une constante contenant la iste des saisons */
   const SEASONS = [
    'Season 1',
    'Season 2',
    'Season 3',
    'Season 4',
    'Season 5',
];
    public function load(ObjectManager $manager)
    {
        // $product = new Product();
        // $manager->persist($product);
        foreach (self::SEASONS as $key => $seasonName){
            $season = new Season();
            $season->setNumber($seasonName);
            $season->setYear($seasonName);
            $season->setDescription($seasonName);
            $season->setProgram($seasonName);
            $manager->persist($season);
            $this->addReference('season_' . $key, $season);
        }

        $manager->flush();
    }

    public function getDependencies()
    {
         // Tu retournes ici toutes les classes de fixtures dont SeasonFixtures dépend
         return [
             ProgramFixtures::class,

         ];
    }
}
