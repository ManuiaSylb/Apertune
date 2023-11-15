<?php

namespace App\Controller;

use App\Entity\Photo;
use App\Form\GallerieType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
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

    #[Route('galleries/new', name: 'app_galleries_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $gallerie = new Gallerie();
        $form = $this->createForm(GallerieType::class, $gallerie);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($gallerie);
            $entityManager->flush();

            return $this->redirectToRoute('app_galleries', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('galleries/new.html.twig', [
            'gallerie' => $gallerie,
            'form' => $form,
        ]);
    }

    #[Route('/galleries/{id}', name: 'galleries_show', requirements: ['id' => '\d+'])]
    public function showGallerie(Gallerie $galerie): Response
    {
        return $this->render('galleries/show.html.twig', [
            'galerie' => $galerie  ,
        ]);
    }
}
