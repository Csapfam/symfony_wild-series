<?php

namespace App\DataFixtures;

use App\Entity\Program;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;
use App\Service\Slugify;

class ProgramFixtures extends Fixture implements DependentFixtureInterface
{
   

   public function __construct(Slugify $slugify)
   {
       $this->slugify = $slugify;
   }
   
    /* Ajout d'une constante contenant la iste des programmes */
   const PROGRAMS = [
    'The Walking Dead',
    'Breaking Bad',
    'Your Honor',
    'Banshee',
    'Homeland',
];
    public function load(ObjectManager $manager)
    {
        // $product = new Product();
        // $manager->persist($product);
        foreach (self::PROGRAMS as $key => $programName){
            $program = new Program();
            $program->setTitle($programName);
            $program->setSummary($programName);
            $program->setPoster($programName);
            $program->setCategory($programName);
            $program->setSlug($this->slugify->generate($programName));
            $manager->persist($program);
            $this->addReference('program_' . $key, $program);
        }
        $manager->flush();
    }

    public function getDependencies()
    {
         // Tu retournes ici toutes les classes de fixtures dont ProgramFixtures dépend
         return [
             ActorFixtures::class,
             CategoryFixtures::class,

         ];
    }
}
