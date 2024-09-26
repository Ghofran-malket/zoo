<?php

namespace App\Controller;

use App\Repository\HabitatsRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HabitatsController extends AbstractController
{
    public function __construct(
        private HabitatsRepository $repository,
        private ZooController $zooController,
        private SliderController $sliderController,)
    {
    }

    public function habitats_in_home_page()
    {
        return $this->repository->findBy([], null, 4);
    }

    #[Route('/habitats', name: 'app_habitats')]
    public function habitats(): Response
    {
        $zooInfo = $this->zooController->index();
        $sliders = $this->sliderController->sliders_in_home_page();
        $habitats= $this->repository->findAll();
        return $this->render('habitats.html.twig', [
            'zooInfo' => $zooInfo,
            'sliders' => $sliders,
            'habitats' => $habitats,
        ]);
    }

    #[Route('/habitats_details/{id}', name: 'app_habitats_details')]
    public function habitats_details(int $id): Response
    {
        $habitat = $this->repository->find($id);

        if (!$habitat) {
            throw $this->createNotFoundException('Habitat not found');
        }
        $zooInfo = $this->zooController->index();
        $sliders = $this->sliderController->sliders_in_home_page();
        return $this->render('habitats_details.html.twig', [
            'habitat' => $habitat,
            'zooInfo' => $zooInfo,
            'sliders' => $sliders,
        ]);
    }
}
