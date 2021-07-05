<?php

namespace App\DataFixtures;

use App\Entity\Episode;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;
use App\Service\Slugify;

class EpisodeFixtures extends Fixture implements DependentFixtureInterface
{

    public function __construct(Slugify $slugify)
    {
        $this->slugify = $slugify;
    }
   
    /* Ajout d'une constante contenant la iste des saisons */
   const EPISODES = [
    'Episode 1',
    'Episode 2',
    'Episode 3',
    'Episode 4',
    'Episode 5',
];
    public function load(ObjectManager $manager)
    {
        // $product = new Product();
        // $manager->persist($product);
        foreach (self::EPISODES as $key => $episodeName){
            $episode = new Episode();
            $episode->setTitle($episodeName);
            $episode->setNumber($episodeName);
            $episode->setSynopsis($episodeName);
            $episode->setSeason($episodeName);
            $episode->setSlug($this->slugify->generate($episodeName));
            $manager->persist($episode);
            $this->addReference('episode' . $key, $episode);
        }
        
        $manager->flush();
    }
    public function getDependencies()
    {
         // Tu retournes ici toutes les classes de fixtures dont SeasonFixtures dépend
         return [
             SeasonFixtures::class,

         ];
    }

}
