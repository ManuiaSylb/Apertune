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
    private const Gallerie1 = 'Gallerie de manuia';
    private const Gallerie2 = "Gallerie d'esteban";


    private static function GallerieDataGenerator()
    {
        yield [self::Gallerie1,"Manuia"];
        yield [self::Gallerie2,"Esteban"];
    }


    private static function PhotoDataGenerator()
    {
        yield ["Margaux", "Manuia",self::Gallerie1];
        yield ["Miroir", "Esteban",self::Gallerie2];
    }


    public function load(ObjectManager $manager): void
    {
        $inventoryRepo = $manager->getRepository(Gallerie::class);

        foreach (self::GallerieDataGenerator() as [$Nom,$Auteur])
        {
            $Gallerie= new Gallerie();
            $Gallerie ->setNom($Nom);
            $Gallerie ->setAuteur($Auteur);
            $manager->persist($Gallerie);
            $manager->flush();

            $this->addReference($Nom,$Gallerie);
        }

        foreach (self::PhotoDataGenerator() as [$Titre, $auteur, $gallerie])
        {
            $photo= new Photo();
            $photo ->setTitre($Titre);
            $photo ->setAuteur($auteur);
            $manager->persist($photo);
            $manager->flush();

            $this->addReference($Titre,$photo);
        }

        $manager->flush();

    }
}
