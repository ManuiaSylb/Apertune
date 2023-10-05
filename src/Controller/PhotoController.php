<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Photo;
use Doctrine\Persistence\ManagerRegistry;

class PhotoController extends AbstractController
{
    /**
     * Show a Photo
     *
     * @param Integer $id (note that the id must be an integer)
     */
    #[Route('/Photo/{id}', name: 'Photo_show', requirements: ['id' => '\d+'])]
    public function show(Photo $photo)
    {
        return $this->render('photo/show.html.twig', [
            'photo' => $photo  ,
        ]);
    }
}

