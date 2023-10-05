<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use App\Entity\Gallerie;
use App\Entity\Membre;
use App\Entity\Photo;
use App\Repository\PhotoRepository;
use phpDocumentor\Reflection\Types\Self_;

class AppFixtures extends Fixture
{
    private const Gallerie1 = 'Gallerie de manuia';
    private const Gallerie2 = "Gallerie d'esteban";


    private static function GallerieDataGenerator()
    {
        yield [self::Gallerie1,"Manuia"];
        yield [self::Gallerie2,"Esteban"];
    }

    private static function MembreGenerator()
    {
        yield ["Manuia",2022,"Tahiti"];
        yield ["Esteban",2023,"France"];
    }

    private static function PhotoDataGenerator()
    {
        yield ["Margaux", "Manuia","Portrait devant un coucher de soleil", "1/320", "1.8", 100, self::Gallerie1];
        yield ["Miroir", "Esteban","Photo reflexion","1/540","3.2",100,self::Gallerie2];
    }


    public function load(ObjectManager $manager): void
    {

        foreach (self::GallerieDataGenerator() as [$Nom,$Auteur])
        {
            $Gallerie= new Gallerie();
            $Gallerie->setNom($Nom);
            $Gallerie->setAuteur($Auteur);
            $manager->persist($Gallerie);

            $this->addReference($Nom,$Gallerie);
        }

        foreach (self::MembreGenerator() as [$pseudo, $annee, $pays])
        {
            $membre = new Membre();
            $membre->setPseudo($pseudo);
            $membre->setAnnee($annee);
            $membre->setPays($pays);
            $manager->persist($membre);

            $this->addReference($pseudo,$membre);
        }

        foreach (self::PhotoDataGenerator() as [$Titre, $auteur, $description, $ss, $ouverture, $iso, $gallerie])
        {
            $gal = $this->getReference($gallerie);
            $photo= new Photo();
            $photo->setTitre($Titre);
            $photo->setAuteur($auteur);
            $photo->setDescription($description);
            $photo->setShutterSpeed($ss);
            $photo->setOuverture($ouverture);
            $photo->setISO($iso);
            $manager->persist($photo);
            $gal->addPhoto($photo);

            $this->addReference($Titre,$photo);
        }

        $manager->flush();

    }
}
