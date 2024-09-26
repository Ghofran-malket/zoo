<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{
    public function __construct(
        private ZooController $zooController,
        private HabitatsController $habitatsController,
        private AnimalController $animalController,
        private ServiceController $serviceController,
        private SliderController $sliderController,)
    {
    }

    #[Route('/home', name: 'app_home')]
    public function index(): Response
    {
        $zooInfo = $this->zooController->index();
        $sliders = $this->sliderController->sliders_in_home_page();
        $habitats = $this->habitatsController->habitats_in_home_page();
        $services = $this->serviceController->services_in_home_page();
        $animaux = $this->animalController->animaux_in_home_page();

        return $this->render('home.html.twig', [
            'zooInfo' => $zooInfo,
            'sliders' => $sliders,
            'habitats' => $habitats,
            'services' => $services,
            'animaux' => $animaux,
        ]);
    }

    #[Route('/contact_us', name: 'app_contact_us')]
    public function contact_us(): Response
    {
        return $this->render('contact_us.html.twig', [
            'controller_name' => 'HomeController',
        ]);
    }
}
