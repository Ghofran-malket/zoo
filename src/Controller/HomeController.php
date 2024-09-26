<?php

namespace App\Controller;

use App\Entity\Opinion;
use App\Form\OpinionType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{
    private $request;

    public function __construct(
        private ZooController $zooController,
        private HabitatsController $habitatsController,
        private AnimalController $animalController,
        private ServiceController $serviceController,
        private SliderController $sliderController,
        private OpinionController $opinionController,
        private EntityManagerInterface $entityManager,
        RequestStack $requestStack,)
    {
        $this->request = $requestStack->getCurrentRequest();
    }

    #[Route('/home', name: 'app_home')]
    public function index(): Response
    {
        $zooInfo = $this->zooController->index();
        $sliders = $this->sliderController->sliders_in_home_page();
        $habitats = $this->habitatsController->habitats_in_home_page();
        $services = $this->serviceController->services_in_home_page();
        $animaux = $this->animalController->animaux_in_home_page();
        $opinions = $this->opinionController->opinions_in_home_page();

        // Create a new Opinion entity
        $opinion = new Opinion();

        // Create the form
        $form = $this->createForm(OpinionType::class, $opinion);
        $form->handleRequest($this->request);

        // Handle form submission
        if ($form->isSubmitted() && $form->isValid()) {
            // Set created_at manually if needed
            $opinion->setCreatedAt(new \DateTimeImmutable());

            // Persist and flush the entity
            $this->entityManager->persist($opinion);
            $this->entityManager->flush();

            // Redirect after form submission to avoid form resubmission issues
            return $this->redirectToRoute('app_home');
        }

        // If form is not submitted or is invalid, render the form
        return $this->render('home.html.twig', [
            'zooInfo' => $zooInfo,
            'sliders' => $sliders,
            'habitats' => $habitats,
            'services' => $services,
            'animaux' => $animaux,
            'opinions' => $opinions,
            'form' => $form->createView(),
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
