<?php

namespace App\Controller;

use App\Repository\ServiceRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ServiceController extends AbstractController
{
    public function __construct(
        private ServiceRepository $repository,
        private ZooController $zooController,
        private SliderController $sliderController,)
    {
    }

    public function services_in_home_page()
    {
        return $this->repository->findBy([], null, 4);
    }

    #[Route('/services', name: 'app_services')]
    public function services(): Response
    {
        $zooInfo = $this->zooController->index();
        $sliders = $this->sliderController->sliders_in_home_page();
        $services= $this->repository->findAll();
        return $this->render('services.html.twig', [
            'zooInfo' => $zooInfo,
            'sliders' => $sliders,
            'services' => $services,
        ]);
    }
}
