<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Gallerie;


class GalleriesController extends AbstractController
{
    #[Route('/galleries', name: 'app_galleries')]
    public function index(): Response
    {
        return $this->render('galleries/index.html.twig', [
            'controller_name' => 'GalleriesController',
        ]);
    }
}
