<?php

namespace App\Controller;

use App\Form\PhotoType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Photo;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\Security\Http\Attribute\IsGranted;



#[IsGranted('ROLE_USER')]
class PhotoController extends AbstractController
{
    /**
     * Show a Photo
     *
     * @param Integer $id (note that the id must be an integer)
     */
    #[Route('photos/{id}', name: 'Photo_show', requirements: ['id' => '\d+'])]
    public function show(Photo $photo)
    {
        return $this->render('photo/show.html.twig', [
            'photo' => $photo  ,
        ]);
    }

    #[Route('photos/new', name: 'app_photo_new', methods: ['GET', 'POST'])]
    #[IsGranted('ROLE_USER')]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $photo = new Photo();
        $photo->setAuteur($this->getUser()->getMembre());
        if ($this->getUser()->getMembre()->getGallerie()==null){
            return $this->redirectToRoute('app_galleries_new', [], Response::HTTP_SEE_OTHER);
        }
        $photo->setGallerie($this->getUser()->getMembre()->getGallerie());
        $form = $this->createForm(PhotoType::class, $photo);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($photo);


            $entityManager->flush();

            return $this->redirectToRoute('app_galleries', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('photo/new.html.twig', [
            'photo' => $photo,
            'form' => $form,

        ]);
    }

    #[Route('photos/{id}/delete', name: 'app_photo_delete', methods: ['POST'])]
    #[IsGranted('ROLE_ADMIN')]
    public function delete(Request $request, Photo $photo, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$photo->getId(), $request->request->get('_token'))) {
            $entityManager->remove($photo);
            $entityManager->flush();
        }

        return $this->redirectToRoute('Photo_show', [], Response::HTTP_SEE_OTHER);
    }
}

