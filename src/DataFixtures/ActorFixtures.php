<?php

namespace App\DataFixtures;

use App\Entity\Actor;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class ActorFixtures extends Fixture
{
    /* Ajout d'une constante contenant la iste des acteurs */
    const ACTORS = [
        'Andrew Lincoln',
        'Norman Reedus',
        'Lauren Cohan',
        'Danai Gurira',
        'Bryan Cranston',
        'Aaron Paul',
        'Antony Starr',
        'Claire Danes',
    ];

    public function load(ObjectManager $manager)
    {   
        foreach (self::ACTORS as $key => $actorName) {
            $actor = new Actor();
            $actor->setName($actorName);
            $manager->persist($actor);
            $this->addReference('actor_' . $key, $actor);
        }
       $manager->flush();
    }
}