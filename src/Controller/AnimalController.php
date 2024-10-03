<?php

namespace App\Controller;

use App\Entity\Animal;
use App\Repository\AnimalRepository;
use App\Repository\ReportDeSanteRepository;
use Doctrine\ORM\EntityManagerInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/animal', name: 'app_animal')]
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

    #[Route('/details/{id}', name: '_details')]
    public function animal_details(int $id, EntityManagerInterface $em): Response
    {
        $animal = $this->repository->find($id);

        if (!$animal) {
            throw $this->createNotFoundException('Animal not found');
        }
        $latestReport = $this->reportDeSanteRepository->findLatestReportForAnimal($id);
        
        if (!$this->getUser()) {
            $consultation_count = $animal->getConsultationCount() + 1 ;
            $animal->setConsultationCount($consultation_count);
            $em->persist($animal);
            $em->flush();
        }

        $zooInfo = $this->zooController->index();
        $sliders = $this->sliderController->sliders_in_home_page();
        return $this->render('animal/details.html.twig', [
            'animal' => $animal,
            'sliders' => $sliders,
            'zooInfo' => $zooInfo,
            'latestReport' => $latestReport,
        ]);
    }

    #[IsGranted("ROLE_ADMIN")]
    #[Route('/admin/list', name: '_list')]
    public function listAnimals(EntityManagerInterface $entityManager): Response
    {
        $this->denyAccessUnlessGranted('ROLE_ADMIN');

        $animals = $entityManager->getRepository(Animal::class)->findAnimalsOrderedByConsultationCount();
        $zooInfo = $this->zooController->index();
        $sliders = $this->sliderController->sliders_in_home_page();
        return $this->render('animal/list.html.twig', [
            'animals' => $animals,
            'zooInfo' => $zooInfo,
            'sliders' => $sliders,
            
        ]);
    }

    #[Route('/', name: '_show')]
    public function index(): Response
    {
        $zooInfo = $this->zooController->index();
        $sliders = $this->sliderController->sliders_in_home_page();
        $animals= $this->repository->findAll();
        return $this->render('animal/show.html.twig', [
            'zooInfo' => $zooInfo,
            'sliders' => $sliders,
            'animals' => $animals,
        ]);
    }

}
