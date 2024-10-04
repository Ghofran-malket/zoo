<?php

namespace App\Controller;

use App\Entity\Opinion;
use App\Form\OpinionType;
use App\Repository\OpinionRepository;
use Doctrine\ORM\EntityManagerInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/opinions', name: 'app_opinions')]
class OpinionController extends AbstractController
{
    
    public function __construct(
        private OpinionRepository $repository,
        private ZooController $zooController,
        private SliderController $sliderController,)
    {
    }

    public function opinions_in_home_page()
    {
        return $this->repository->findLatestTwoAuthorised();
    }

    //show services page
    #[Route('/', name: '_show')]
    public function show(): Response
    {
        $zooInfo = $this->zooController->index();
        $sliders = $this->sliderController->sliders_in_home_page();
        $opinions= $this->repository->findAllAuthorised();
        return $this->render('opinions/show.html.twig', [
            'zooInfo' => $zooInfo,
            'sliders' => $sliders,
            'opinions' => $opinions,
        ]);
    }

    #[Route('/employee', name: '_show_all')]
    public function showEmployee(): Response
    {
        if (!$this->isGranted('ROLE_ADMIN') && !$this->isGranted('ROLE_EMPLOYEE')) {
            throw $this->createAccessDeniedException('You do not have access to this page.');
        }
        $zooInfo = $this->zooController->index();
        $sliders = $this->sliderController->sliders_in_home_page();
        $opinions= $this->repository->findAll();
        return $this->render('opinions/show.html.twig', [
            'zooInfo' => $zooInfo,
            'sliders' => $sliders,
            'opinions' => $opinions,
        ]);
    }


    #[IsGranted("ROLE_EMPLOYEE")]
    #[Route('/employee/edit/{id}', name: '_edit')]
    public function authorize(Opinion $opinion, EntityManagerInterface $em): Response
    {
        $opinion->setIsAuthorized(true);
        $opinion->setUpdatedAt(new \DateTimeImmutable());
        $em->flush();
        return $this->redirectToRoute('app_opinions_show_all');
    }

    #[IsGranted("ROLE_EMPLOYEE")]
    #[Route('/employee/delete/{id}', name: '_delete')]
    public function delete(Request $request, Opinion $opinion, EntityManagerInterface $em): Response
    {
        if ($this->isCsrfTokenValid('delete'.$opinion->getId(), $request->request->get('_token'))) {
            $em->remove($opinion);
            $em->flush();
        }
        return $this->redirectToRoute('app_opinions_show_all');
    }
}
