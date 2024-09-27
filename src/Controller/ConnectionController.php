<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

class ConnectionController extends AbstractController
{
    public function __construct(
        private ZooController $zooController,
        private SliderController $sliderController,)
    {
    }

    #[Route('/connection', name: 'app_connection')]
    public function connection(): Response
    {
        $zooInfo = $this->zooController->index();
        $sliders = $this->sliderController->sliders_in_home_page();
        return $this->render('connection.html.twig', [
            'zooInfo' => $zooInfo,
            'sliders' => $sliders,
        ]);
    }

    #[Route('/login', name: 'login')]
    public function login(AuthenticationUtils $authenticationUtils): Response
    {
        $zooInfo = $this->zooController->index();
        $sliders = $this->sliderController->sliders_in_home_page();
        // Get the login error if there is one
        $error = $authenticationUtils->getLastAuthenticationError();

        // Last username entered by the user
        $lastUsername = $authenticationUtils->getLastUsername();

        return $this->render('connection.html.twig', [
            'last_username' => $lastUsername,
            'error' => $error,
            'zooInfo' => $zooInfo,
            'sliders' => $sliders,
        ]);
    }


    #[Route('/logout', name: 'logout')]
    public function logout()
    {
        // Symfony handles the logout automatically
    }

}
