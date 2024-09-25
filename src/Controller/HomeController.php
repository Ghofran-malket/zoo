<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{
    public function __construct(
        private ZooController $zooController,
        private HabitatsController $habitatsController)
    {
    }

    #[Route('/home', name: 'app_home')]
    public function index(): Response
    {
        $zooInfo = $this->zooController->index();
        $habitats = $this->habitatsController->habitats_in_home_page();
        return $this->render('home.html.twig', [
            'zooInfo' => $zooInfo,
            'habitats' => $habitats,
        ]);
    }

    #[Route('/services', name: 'app_services')]
    public function services(): Response
    {
        return $this->render('services.html.twig', [
            'controller_name' => 'HomeController',
        ]);
    }

    

    #[Route('/animal_details', name: 'app_animal_details')]
    public function animal_details(): Response
    {
        return $this->render('animal_details.html.twig', [
            'controller_name' => 'HomeController',
        ]);
    }

    #[Route('/contact_us', name: 'app_contact_us')]
    public function contact_us(): Response
    {
        return $this->render('contact_us.html.twig', [
            'controller_name' => 'HomeController',
        ]);
    }

    #[Route('/connection', name: 'app_connection')]
    public function connection(): Response
    {
        return $this->render('connection.html.twig', [
            'controller_name' => 'HomeController',
        ]);
    }
}
