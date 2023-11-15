<?php

namespace App\Controller;

use App\Entity\Album;
use App\Entity\Membre;
use App\Entity\Photo;
use App\Form\Album1Type;
use App\Repository\AlbumRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;

#[Route('/album')]
class AlbumController extends AbstractController
{
    #[Route('/', name: 'app_album_index', methods: ['GET'])]
    public function index(AlbumRepository $albumRepository): Response
    {
        return $this->render('album/index.html.twig', [
            'albums' => $albumRepository->findBy(['Publie' => true]),
        ]);
    }

    #[Route('/new', name: 'app_album_new', methods: ['GET', 'POST'])]
    #[IsGranted('ROLE_USER')]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $album = new Album();
        $album->setAuteur($this->getUser()->getMembre());
        $form = $this->createForm(Album1Type::class, $album);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($album);
            $entityManager->flush();

            return $this->redirectToRoute('app_album_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('album/new.html.twig', [
            'album' => $album,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_album_show', methods: ['GET'])]
    public function show(Album $album): Response
    {
        $hasAccess = false;
        if($this->isGranted('ROLE_ADMIN') || $album->isPublie()) {
                $hasAccess = true;
        }
        else {
        $user = $this->getUser();
        if( $user ) {
            $membre = $user->getMembre();
            if ( $membre &&  ($membre == $album->getAuteur()) ) {
                $hasAccess = true;
            }
        }
    }
    if(! $hasAccess) {
        throw $this->createAccessDeniedException("Vous n'avez pas accès à cet album");
    }
    return $this->render('album/show.html.twig', [
        'album' => $album,
    ]);
    }

    #[Route('/{id}/edit', name: 'app_album_edit', methods: ['GET', 'POST'])]
    #[IsGranted('ROLE_USER')]
    public function edit(Request $request, Album $album, EntityManagerInterface $entityManager): Response
    {
        if ( $this->getUser()->getMembre()->getPseudo()!=$album->getAuteur() && $this->getUser()->getRoles()!=['ROLE_ADMIN','ROLE_USER']){
            return $this->redirectToRoute('app_album_index', [], Response::HTTP_SEE_OTHER);
        }
        $form = $this->createForm(Album1Type::class, $album);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_album_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('album/edit.html.twig', [
            'album' => $album,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_album_delete', methods: ['POST'])]
    #[IsGranted('ROLE_ADMIN')]
    public function delete(Request $request, Album $album, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$album->getId(), $request->request->get('_token'))) {
            $entityManager->remove($album);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_album_index', [], Response::HTTP_SEE_OTHER);
    }
    #[Route('/{id}/photo/{photo_id}', methods: ['GET'], name: 'app_album_photo_show')]
    #[IsGranted('ROLE_USER')]
    public function PhotoShow(Album $album, Photo $photo): Response
        {
        if(! $album->getObjets()->contains($photo)) {
            throw $this->createNotFoundException("Il n'y a pas de photo dans cet album!");
        }

        if(! $album->isPublie()) {
            throw $this->createAccessDeniedException("Vous n'avez pas les permissions d'accès!");
        }
       $id=$photo->getId();
        return $this->redirect("/photos/$id");

        }
}
