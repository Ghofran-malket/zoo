<?php

namespace App\Controller;

use App\Entity\Alimentation;
use App\Form\AlimentaionType;
use App\Repository\AlimentationRepository;
use App\Repository\AnimalRepository;
use Doctrine\ORM\EntityManagerInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/alimentation', name: 'app_alimentation')]
class AlimentationController extends AbstractController
{
    public function __construct(
        private AlimentationRepository $repository,
        private AnimalRepository $animalRrepository,
        private ZooController $zooController,
        private SliderController $sliderController,)
    {
    }

    #[Route('/', name: '_show')]
    public function index(): Response
    {
        $zooInfo = $this->zooController->index();
        $sliders = $this->sliderController->sliders_in_home_page();
        $alimentations = $this->repository->findAll();
        return $this->render('alimentation/show.html.twig', [
            'zooInfo' => $zooInfo,
            'sliders' => $sliders,
            'alimentations' => $alimentations,
        ]);
    }

    #[IsGranted("ROLE_EMPLOYEE")]
    #[Route('/employee/{animalId}', name: '_create')]
    public function createAlimentation(Request $request, EntityManagerInterface $em, int $animalId): Response
    {
        $zooInfo = $this->zooController->index();
        $sliders = $this->sliderController->sliders_in_home_page();
        $animal = $this->animalRrepository->find($animalId);

        if (!$animal) {
            throw $this->createNotFoundException('Animal not found');
        }

        $alimentation = new Alimentation();
    
        $form = $this->createForm(AlimentaionType::class, $alimentation);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // Get the logged-in employee (assumes employees are users)
            $alimentation->setEmployee($this->getUser());
            $alimentation->setAnimal($animal);
            $alimentation->setFeedingTime(new \DateTime());

            // Persist and flush the entity
            $em->persist($alimentation);
            $em->flush();

            // Redirect to a success page or the dashboard
            return $this->redirectToRoute('app_alimentation_show');
        }

        // Render the form in the template
        return $this->render('alimentation/new.html.twig', [
            'zooInfo' => $zooInfo,
            'sliders' => $sliders,
            'form' => $form->createView(),
            'animal' => $animal,
        ]);
    }
}
