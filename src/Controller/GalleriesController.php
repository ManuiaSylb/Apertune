<?php

namespace App\Controller;

use App\Entity\Photo;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Gallerie;
use Doctrine\Persistence\ManagerRegistry;



class GalleriesController extends AbstractController
{
    #[Route('/galleries', name: 'app_galleries')]
    public function listGalleries(ManagerRegistry $doctrine): Response
    {
        $entityManager= $doctrine->getManager();
        $galleries = $entityManager->getRepository(Gallerie::class)->findAll();

        // dump($galleries);
        return $this->render('galleries/index.html.twig', [
            'galleries' => $galleries,
        ]);
    }

    #[Route('/galleries/{id}', name: 'galleries_show', requirements: ['id' => '\d+'])]
    public function showGallerie(Photo $photos): Response
    {
        return $this->render('galleries/show.html.twig', [
            'photo' => $photos  ,
        ]);
    }
}
