<?php

namespace App\Controller;

use App\Entity\Service;
use App\Form\ServiceType;
use App\Repository\ServiceRepository;
use Doctrine\ORM\EntityManagerInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;


#[Route('/services', name: 'app_services')]
class ServiceController extends AbstractController
{
    public function __construct(
        private ServiceRepository $repository,
        private ZooController $zooController,
        private SliderController $sliderController,)
    {
    }

    public function services_in_home_page()
    {
        return $this->repository->findBy([], null, 4);
    }

    //show services page
    #[Route('/', name: '_show')]
    public function services(): Response
    {
        $zooInfo = $this->zooController->index();
        $sliders = $this->sliderController->sliders_in_home_page();
        $services= $this->repository->findAll();
        return $this->render('services/show.html.twig', [
            'zooInfo' => $zooInfo,
            'sliders' => $sliders,
            'services' => $services,
        ]);
    }

    #[IsGranted("ROLE_ADMIN")]
    #[Route('/admin/create', name: '_create')]
    public function new(Request $request, EntityManagerInterface $em): Response
    {
        $service = new Service();
        $zooInfo = $this->zooController->index();
        $sliders = $this->sliderController->sliders_in_home_page();
        $form = $this->createForm(ServiceType::class, $service);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $service->setCreatedAt(new \DateTimeImmutable());
            $em->persist($service);
            $em->flush();

            return $this->redirectToRoute('app_services_show');
        }

        return $this->render('services/new.html.twig', [
            'service' => $service,
            'form' => $form->createView(),
            'zooInfo' => $zooInfo,
            'sliders' => $sliders,
        ]);
    }

    #[IsGranted("ROLE_ADMIN")]
    #[Route('/admin/edit/{id}', name: '_edit')]
    //methods={"GET", "POST"})]
    public function edit(Request $request, Service $service, EntityManagerInterface $em): Response
    {
        $zooInfo = $this->zooController->index();
        $sliders = $this->sliderController->sliders_in_home_page();
        $form = $this->createForm(ServiceType::class, $service);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $service->setUpdatedAt(new \DateTimeImmutable());
            $em->flush();

            return $this->redirectToRoute('app_services_show');
        }

        return $this->render('services/edit.html.twig', [
            'service' => $service,
            'form' => $form->createView(),
            'zooInfo' => $zooInfo,
            'sliders' => $sliders,
        ]);
    }

    #[IsGranted("ROLE_ADMIN")]
    #[Route('/admin/delete/{id}', name: '_delete')]
    public function delete(Request $request, Service $service, EntityManagerInterface $em): Response
    {
        if ($this->isCsrfTokenValid('delete'.$service->getId(), $request->request->get('_token'))) {
            $em->remove($service);
            $em->flush();
        }

        return $this->redirectToRoute('app_services_show');
    }
}
