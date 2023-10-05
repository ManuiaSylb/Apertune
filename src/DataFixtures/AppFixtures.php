<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use App\Entity\Gallerie;
use App\Entity\Membre;
use App\Entity\Photo;
use App\Repository\PhotoRepository;

class AppFixtures extends Fixture
{

    /**
     * Generates initialization data for photos : [title, date, author]
     * @return \\Generator
     */
    private static function PhotoDatagenerator(): \Generator
    {
        yield ["Coucher de soleil", "", "Manuia"];
        yield ["Miroir", "", "Eric"];
        yield ["Night Sky", "", "Esteban"];
        yield ["Margaux", "", "Manuia"];
        yield ["Paradoxal", "", "Eric"];
        yield ["Monster", "", "Manuia"];
    }


    /**
     * Generates initialization data for galleries : [Title, author]
     * @return \\Generator
     */
    private static function GallerieDatagenerator(): \Generator
    {
        yield ["Gallerie Manuia", "Manuia"];
        yield ["Gallerie Manuia", "Eric"];
        yield ["Gallerie Manuia", "Esteban"];
    }



    public function load(ObjectManager $manager): void
    {
        // $product = new Product();
        // $manager->persist($product);

        $manager->flush();
    }
}
