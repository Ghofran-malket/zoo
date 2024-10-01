<?php

namespace App\Controller;

use App\Repository\AnimalRepository;
use App\Repository\ReportDeSanteRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AnimalController extends AbstractController
{
    public function __construct(
        private AnimalRepository $repository,
        private ZooController $zooController,
        private SliderController $sliderController,
        private ReportDeSanteRepository $reportDeSanteRepository,)
    {
    }

    public function animaux_in_home_page()
    {
        return $this->repository->findBy([], null, 5);
    }

    #[Route('/animal_details/{id}', name: 'app_animal_details')]
    public function animal_details(int $id): Response
    {
        $animal = $this->repository->find($id);

        if (!$animal) {
            throw $this->createNotFoundException('Animal not found');
        }
        $latestReport = $this->reportDeSanteRepository->findLatestReportForAnimal($id);

        $zooInfo = $this->zooController->index();
        $sliders = $this->sliderController->sliders_in_home_page();
        return $this->render('animal_details.html.twig', [
            'animal' => $animal,
            'sliders' => $sliders,
            'zooInfo' => $zooInfo,
            'latestReport' => $latestReport,
        ]);
    }
}
