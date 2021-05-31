<?php

namespace App\DataFixtures;

use App\Entity\Category;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class CategoryFixtures extends Fixture
{
    /* Ajout d'une constante contenant la iste des catégories */
    const CATEGORIES = [
        'Action',
        'Aventure',
        'Animation',
        'Fantastique',
        'Horreur',
    ];

    public function load(ObjectManager $manager)
    {
        /* exemple quete 09 : création de la 1ére fixture

        $category = new Category();
        $category->setName('Horreur');
        $manager->persist($category);
        $manager->flush();
        */
        
        foreach (self::CATEGORIES as $key => $categoryName){
            $category = new Category();
            $category->setName($categoryName);
            $manager->persist($category);
        }
       $manager->flush();
    }
}