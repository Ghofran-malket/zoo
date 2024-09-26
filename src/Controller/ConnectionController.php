<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ConnectionController extends AbstractController
{
    public function __construct(
        private ZooController $zooController,
        private SliderController $sliderController,)
    {
    }

    #[Route('/connection', name: 'app_connection')]
    public function connection(): Response
    {
        $zooInfo = $this->zooController->index();
        $sliders = $this->sliderController->sliders_in_home_page();
        return $this->render('connection.html.twig', [
            'zooInfo' => $zooInfo,
            'sliders' => $sliders,
        ]);
    }

}
