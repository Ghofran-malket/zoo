<?php

namespace App\Controller;

use App\Entity\Animal;
use App\Form\AnimalType;
use App\Repository\AnimalRepository;
use App\Repository\ReportDeSanteRepository;
use Doctrine\ORM\EntityManagerInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Service\MongoDBService;

#[Route('/animal', name: 'app_animal')]
class AnimalController extends AbstractController
{
    private $mongoDBService;
    public function __construct(
        private AnimalRepository $repository,
        private ZooController $zooController,
        private SliderController $sliderController,
        private ReportDeSanteRepository $reportDeSanteRepository,
        MongoDBService $mongoDBService
        )
    {
        $this->mongoDBService = $mongoDBService;
    }

    public function animaux_in_home_page()
    {
        return $this->repository->findBy([], null, 5);
    }

    #[Route('/details/{id}', name: '_details')]
    public function animal_details(int $id): Response
    {
        $animal = $this->repository->find($id);

        if (!$animal) {
            throw $this->createNotFoundException('Animal not found');
        }
        $latestReport = $this->reportDeSanteRepository->findLatestReportForAnimal($id);
        
        if (!$this->getUser()) {
            //augmenter la consultaion count quand le client appele cette route
            $this->mongoDBService->incrementConsultation($animal);
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
    public function listAnimals(): Response
    {
        $this->denyAccessUnlessGranted('ROLE_ADMIN');

        $animals = $this->mongoDBService->findAnimalsOrderedByConsultationCount();
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

    #[IsGranted("ROLE_ADMIN")]
    #[Route('/admin/create', name: '_create')]
    public function new(Request $request, EntityManagerInterface $em): Response
    {
        $animal = new Animal();
        $zooInfo = $this->zooController->index();
        $sliders = $this->sliderController->sliders_in_home_page();
        $form = $this->createForm(AnimalType::class, $animal);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $files = $form->get('images')->getData();
            $images = [];
            if ($files) {
                
                foreach ($files as $file) {
                    $filename = md5(uniqid()) . '.' . $file->guessExtension();
                    $file->move($this->getParameter('images_directory'), $filename);
                    $images[] = $filename;
                }
            }
            $animal->setImages($images);
            $animal->setCreatedAt(new \DateTimeImmutable());
            $animal->setConsultationCount(0);
            $em->persist($animal);
            $em->flush();
            return $this->redirectToRoute('app_animal_show');
        }

        return $this->render('animal/new.html.twig', [
            'animal' => $animal,
            'form' => $form->createView(),
            'zooInfo' => $zooInfo,
            'sliders' => $sliders,
        ]);
    }

}
