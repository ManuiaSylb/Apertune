<?php

namespace App\DataFixtures;

use App\Entity\Album;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;
use App\Entity\Gallerie;
use App\Entity\Membre;
use App\Entity\Photo;
use App\Entity\User;
use App\Repository\PhotoRepository;
use phpDocumentor\Reflection\Types\Self_;

class AppFixtures extends Fixture implements DependentFixtureInterface
{
    private const Gallerie1 = 'Galerie de Manuia';
    private const Gallerie2 = "Galerie d'Esteban";

    private const Album1 = 'Portraits';
    private const Album2 = "Artistique";
    private const Album3 = "Art";


    private static function GallerieDataGenerator()
    {
        yield [self::Gallerie1,"Manuia"];
        yield [self::Gallerie2,"Esteban"];
    }

    private static function AlbumDataGenerator()
    {
        yield [self::Album1,"Manuia",True,"Photos de portraits"];
        yield [self::Album2,"Manuia",False,"Photos cinématiques"];
        yield [self::Album3,"Esteban",True,"Photos d'art"];
    }


    private static function MembreGenerator()
    {
        yield [
            'chris@localhost',
            'Chris',
            'France',
            2023
        ];
        yield [
            'anna@localhost',
            'Anna',
            'France',
            2023
        ];
        yield [
            'manuia@localhost',
            'Manuia',
            'Tahiti',
            2021
        ];
        yield [
            'esteban@localhost',
            'Esteban',
            'France',
            2022
        ];
    }

    private static function PhotoDataGenerator()
    {
        yield ["Margaux", "Manuia","Portrait devant un coucher de soleil", "1/320", "1.8", 100, self::Gallerie1, [self::Album1]];
        yield ["17h30", "Manuia","Photo d'un couché de soleil","1/540","3.2",100,self::Gallerie1, [self::Album2,self::Album1]];
        yield ["Vénuse de Milo", "Esteban","Photo de la statue de la Vénus","1/540","3.2",100,self::Gallerie2, [self::Album3]];
    }

    public function getDependencies()
    {
        return [
            UserFixtures::class,
        ];
    }
    public function load(ObjectManager $manager): void
    {
        foreach (self::MembreGenerator() as [$useremail, $pseudo, $pays, $annee])
        {
            $membre = new Membre();
            if ($useremail) {
                $user = $manager->getRepository(User::class)->findOneByEmail($useremail);
                $membre->setUser($user);
            }
            $membre->setPseudo($pseudo);
            $membre->setAnnee($annee);
            $membre->setPays($pays);
            $manager->persist($membre);

            $this->addReference($pseudo,$membre);
        }


        foreach (self::GallerieDataGenerator() as [$Nom,$Auteur])
        {
            $aut= $this->getReference($Auteur);
            $Gallerie= new Gallerie();
            $Gallerie->setNom($Nom);
            $Gallerie->setAuteur($aut);
            $manager->persist($Gallerie);

            $this->addReference($Nom,$Gallerie);
        }



        foreach (self::AlbumDataGenerator() as [$Nom,$auteur,$publie])
        {
            $aut= $this->getReference($auteur);
            $Album = new Album();
            $Album->setNom($Nom);
            $Album->setAuteur($aut);
            $Album->setPublie($publie);

            $manager->persist($Album);

            $this->addReference($Nom,$Album);
        }

        foreach (self::PhotoDataGenerator() as [$Titre, $auteur, $description, $ss, $ouverture, $iso, $gallerie,$albums])
        {
            $gal = $this->getReference($gallerie);
            $aut= $this->getReference($auteur);
            $photo= new Photo();
            foreach ($albums as $album){
                $alb = $this->getReference($album);
                $alb->addObjet($photo);
            }
            $photo->setTitre($Titre);
            $photo->setAuteur($aut);
            $photo->setDescription($description);
            $photo->setShutterSpeed($ss);
            $photo->setOuverture($ouverture);
            $photo->setOuverture($ouverture);
            $photo->setISO($iso);

            $manager->persist($photo);
            $aut-> addPhoto($photo);
            $gal->addPhoto($photo);


            $this->addReference($Titre,$photo);
        }

        $manager->flush();

    }
}
