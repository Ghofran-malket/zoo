<?php

namespace App\Controller;

use App\Entity\Habitats;
use App\Form\HabitatType;
use App\Repository\HabitatsRepository;
use Doctrine\ORM\EntityManagerInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/habitats', name: 'app_habitats')]
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

    #[Route('/', name: '_show')]
    public function habitats(): Response
    {
        $zooInfo = $this->zooController->index();
        $sliders = $this->sliderController->sliders_in_home_page();
        $habitats= $this->repository->findAll();
        return $this->render('habitats/show.html.twig', [
            'zooInfo' => $zooInfo,
            'sliders' => $sliders,
            'habitats' => $habitats,
        ]);
    }

    #[Route('/details/{id}', name: '_details')]
    public function habitats_details(int $id): Response
    {
        $habitat = $this->repository->find($id);

        if (!$habitat) {
            throw $this->createNotFoundException('Habitat not found');
        }
        $zooInfo = $this->zooController->index();
        $sliders = $this->sliderController->sliders_in_home_page();
        return $this->render('habitats/details.html.twig', [
            'habitat' => $habitat,
            'zooInfo' => $zooInfo,
            'sliders' => $sliders,
        ]);
    }

    #[IsGranted("ROLE_ADMIN")]
    #[Route('/admin/create', name: '_create')]
    public function new(Request $request, EntityManagerInterface $em): Response
    {
        $habitat = new Habitats();
        $zooInfo = $this->zooController->index();
        $sliders = $this->sliderController->sliders_in_home_page();
        $form = $this->createForm(HabitatType::class, $habitat);
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
        
            $habitat->setImages($images);
            $habitat->setCreatedAt(new \DateTimeImmutable());
            $em->persist($habitat);
            $em->flush();

            return $this->redirectToRoute('app_habitats_show');
        }

        return $this->render('habitats/new.html.twig', [
            'habitat' => $habitat,
            'form' => $form->createView(),
            'zooInfo' => $zooInfo,
            'sliders' => $sliders,
        ]);
    }

    #[IsGranted("ROLE_ADMIN")]
    #[Route('/admin/edit/{id}', name: '_edit')]
    //methods={"GET", "POST"})]
    public function edit(Request $request, Habitats $habitat, EntityManagerInterface $em): Response
    {
        $zooInfo = $this->zooController->index();
        $sliders = $this->sliderController->sliders_in_home_page();
        $form = $this->createForm(HabitatType::class, $habitat);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $habitat->setUpdatedAt(new \DateTimeImmutable());
            $em->flush();

            return $this->redirectToRoute('app_habitats_details');
        }

        return $this->render('habitats/edit.html.twig', [
            'habitat' => $habitat,
            'form' => $form->createView(),
            'zooInfo' => $zooInfo,
            'sliders' => $sliders,
        ]);
    }

    #[IsGranted("ROLE_ADMIN")]
    #[Route('/admin/delete/{id}', name: '_delete')]
    public function delete(Request $request, Habitats $habitat, EntityManagerInterface $em): Response
    {
        if ($this->isCsrfTokenValid('delete'.$habitat->getId(), $request->request->get('_token'))) {
            $em->remove($habitat);
            $em->flush();
        }

        return $this->redirectToRoute('app_habitats_show');
    }

}
