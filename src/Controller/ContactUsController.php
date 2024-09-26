<?php

namespace App\Controller;

use App\Entity\Contact;
use App\Form\ContactType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ContactUsController extends AbstractController
{
    private $request;

    public function __construct(
        private ZooController $zooController,
        private SliderController $sliderController,
        private EntityManagerInterface $entityManager,
        RequestStack $requestStack,)
    {
        $this->request = $requestStack->getCurrentRequest();
    }

    #[Route('/contact_us', name: 'app_contact_us')]
    public function contact_us(): Response
    {
        $zooInfo = $this->zooController->index();
        $sliders = $this->sliderController->sliders_in_home_page();
        $contact = new Contact();
        $form = $this->createForm(ContactType::class, $contact);
        $form->handleRequest($this->request);

        if ($form->isSubmitted() && $form->isValid()) {
            $contact->setCreatedAt(new \DateTimeImmutable());

            $this->entityManager->persist($contact);
            $this->entityManager->flush();

            // Flash message for success
            $this->addFlash('success', 'Your message has been sent successfully!');

            // Redirect after form submission
            return $this->redirectToRoute('app_contact_us');
        }

        return $this->render('contact_us.html.twig', [
            'zooInfo' => $zooInfo,
            'sliders' => $sliders,
            'form' => $form->createView(),
        ]);
    }
}
