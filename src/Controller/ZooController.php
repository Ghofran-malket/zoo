<?php

namespace App\Controller;

use App\Entity\Zoo;
use App\Form\ZooInfoType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\ZooRepository;
use Doctrine\ORM\EntityManagerInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Component\HttpFoundation\Request;

#[Route('/zoo', name: 'app_zoo')]
class ZooController extends AbstractController
{
    public function __construct(private ZooRepository $repository,private SliderController $sliderController,)
    {
    }

    public function index()
    {
        return $this->repository->findAll();
    }

    #[IsGranted("ROLE_ADMIN")]
    #[Route('/admin/create', name: '_create')]
    public function new(Request $request, EntityManagerInterface $em): Response
    {
        $zooInfo = $this->index();
        $sliders = $this->sliderController->sliders_in_home_page();
        $zoo = new Zoo();
        $form = $this->createForm(ZooInfoType::class, $zoo);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $zoo->setUpdatedAt(new \DateTimeImmutable());
            $zoo->setCreatedAt(new \DateTimeImmutable());
            $em->persist($zoo);
            $em->flush();
            return $this->redirectToRoute('app_home');
        }

        return $this->render('zoo/new.html.twig', [
            'form' => $form->createView(),
            'zooInfo' => $zooInfo,
            'sliders' => $sliders,
        ]);
    }
}
