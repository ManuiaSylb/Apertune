<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Gallerie;
use Doctrine\Persistence\ManagerRegistry;


class GalleriesController extends AbstractController
{
    #[Route('/galleries', name: 'app_galleries')]
    public function listAction(ManagerRegistry $doctrine): Response
    {
        $entityManager= $doctrine->getManager();
        $galleries = $entityManager->getRepository(Gallerie::class)->findAll();

        // dump($galleries);
        return $this->render('galleries/index.html.twig', [
            'galleries' => $galleries,
        ]);
    }

}
