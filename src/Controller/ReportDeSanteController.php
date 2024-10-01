<?php

namespace App\Controller;

use App\Entity\ReportDeSante;
use App\Form\ReportDeSanteType;
use App\Repository\AnimalRepository;
use App\Repository\ReportDeSanteRepository;
use Doctrine\ORM\EntityManagerInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/reportDeSante', name: 'app_report_de_sante')]
class ReportDeSanteController extends AbstractController
{
    public function __construct(
        private ReportDeSanteRepository $repository,
        private ZooController $zooController,
        private SliderController $sliderController,
        private AnimalRepository $animalRepository,)
    {
    }

    #[Route('/', name: '_show')]
    public function index(): Response
    {
        $report= $this->repository->findAll();
        return $this->render('report_de_sante/index.html.twig', [
            'report' => $report,
        ]);
    }

    #[IsGranted("ROLE_VETERINARY")]
    #[Route('/veterinary/create/{id}', name: '_create')]
    public function new(Request $request, EntityManagerInterface $em, int $id): Response
    {
        // Find the Animal by ID
        $animal = $this->animalRepository->find($id);

        if (!$animal) {
            throw $this->createNotFoundException('Animal not found');
        }

        // Create a new ReportDeSante and set the Animal
        $report = new ReportDeSante();
        $report->setAnimal($animal);
        $zooInfo = $this->zooController->index();
        $sliders = $this->sliderController->sliders_in_home_page();
        $form = $this->createForm(ReportDeSanteType::class, $report);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $report->setCreatedAt(new \DateTimeImmutable());
            
            $em->persist($report);
            $em->flush();

            return $this->redirectToRoute('app_animal_details', ['id' => $id]);
        }

        return $this->render('veterinaire/new.html.twig', [
            'report' => $report,
            'form' => $form->createView(),
            'zooInfo' => $zooInfo,
            'sliders' => $sliders,
        ]);
    }
}
