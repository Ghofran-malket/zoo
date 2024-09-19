<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{
    #[Route('/home', name: 'app_home')]
    public function index(): Response
    {
        return $this->render('home.html.twig', [
            'controller_name' => 'HomeController',
        ]);
    }

    #[Route('/services', name: 'app_services')]
    public function services(): Response
    {
        return $this->render('services.html.twig', [
            'controller_name' => 'HomeController',
        ]);
    }

    #[Route('/habitats', name: 'app_habitats')]
    public function habitats(): Response
    {
        return $this->render('habitats.html.twig', [
            'controller_name' => 'HomeController',
        ]);
    }

    #[Route('/habitats_details', name: 'app_habitats_details')]
    public function habitats_details(): Response
    {
        return $this->render('habitats_details.html.twig', [
            'controller_name' => 'HomeController',
        ]);
    }
}
