<?php

namespace App\Controller;

use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Membre;

class MembreController extends AbstractController
{
    #[Route('/membres', name: 'app_membre')]
    public function index(ManagerRegistry $doctrine): Response
    {
        $entityManager= $doctrine->getManager();
        $membres = $entityManager->getRepository(Membre::class)->findAll();

        return $this->render('membre/index.html.twig', [
            'membres' => $membres,
        ]);
    }

    #[Route('/membre/{id}', name: 'membre_show', requirements: ['id' => '\d+'])]
    public function showMembre(Membre $membre): Response
    {
        return $this->render('membre/show.html.twig', [
            'membre' => $membre  ,
        ]);
    }
}
