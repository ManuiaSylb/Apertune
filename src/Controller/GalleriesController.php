<?php

namespace App\Controller;

use App\Entity\Membre;
use App\Entity\Photo;
use App\Entity\User;
use App\Form\GallerieType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Gallerie;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\Security\Http\Attribute\IsGranted;


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
    #[IsGranted('ROLE_USER')]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $gallerie = new Gallerie();
        if(($this->getUser()->getMembre()->getGallerie())) {
            return $this->redirectToRoute('app_galleries', [], Response::HTTP_SEE_OTHER);
        }
        else{

            $gallerie->setAuteur($this->getUser()->getMembre());
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

    }

    #[Route('galleries/{id}/edit', name: 'app_galleries_edit', methods: ['GET', 'POST'])]
    #[IsGranted('ROLE_USER')]
    public function edit(Request $request, Gallerie $galerie, EntityManagerInterface $entityManager): Response
    {
        if ( $this->getUser()->getMembre()->getPseudo()!=$galerie->getAuteur() && $this->getUser()->getRoles()!=['ROLE_ADMIN','ROLE_USER']){
            return $this->redirectToRoute('app_galleries', [], Response::HTTP_SEE_OTHER);
        }
        $form = $this->createForm(GallerieType::class, $galerie);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_galleries', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('galleries/edit.html.twig', [
            'galerie' => $galerie,
            'form' => $form,
        ]);
    }


    #[Route('/galleries/{id}', name: 'galleries_show', requirements: ['id' => '\d+'])]
    #[IsGranted('ROLE_USER')]
    public function showGallerie(Gallerie $galerie): Response
    {
        $hasAccess = $this->isGranted('ROLE_ADMIN') ||
            ($this->getUser()->getMembre() == $galerie->getAuteur());
        if(! $hasAccess) {
            throw $this->createAccessDeniedException("Vous n'avez pas accès à cette galerie");
        }

        return $this->render('galleries/show.html.twig', [
            'galerie' => $galerie  ,
        ]);
    }
}
