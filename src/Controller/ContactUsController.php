<?php

namespace App\Controller;

use App\Entity\Contact;
use App\Form\ContactType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Mime\Email;

#[Route('/contact_us', name: 'app_contact_us')]
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

    #[Route('/', name: '_send')]
    public function contact_us(MailerInterface $mailer): Response
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

            // Envoi de l'email au zoo
            $email = (new Email())
                ->from($contact->getEmail())
                ->to('zoo@example.com') // Email du zoo
                ->subject('Contact - ' . $contact->getTitle())
                ->text($contact->getDescription());

            $mailer->send($email);

            // Redirection ou message de succès
            $this->addFlash('success', 'Votre demande a été envoyée avec succès.');

            // Redirect after form submission
            return $this->redirectToRoute('app_home');
        }

        return $this->render('contact_us.html.twig', [
            'zooInfo' => $zooInfo,
            'sliders' => $sliders,
            'form' => $form->createView(),
        ]);
    }
}
