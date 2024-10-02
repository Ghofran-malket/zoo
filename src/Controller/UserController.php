<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\UserType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/user', name: 'app_user')]
class UserController extends AbstractController
{
    public function __construct(
        private ZooController $zooController,
        private SliderController $sliderController,)
    {
    }

    #[Route('/admin/create', name: '_create')]
    public function createUser(Request $request, EntityManagerInterface $entityManager,
    UserPasswordHasherInterface $passwordHasher): Response {

        $this->denyAccessUnlessGranted('ROLE_ADMIN');

        $user = new User();
        $form = $this->createForm(UserType::class, $user);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // Hash du mot de passe
            $user->setPassword(
                $passwordHasher->hashPassword($user, $user->getPassword())
            );

            // Sauvegarde de l'utilisateur
            $entityManager->persist($user);
            $entityManager->flush();

            return $this->redirectToRoute('app_user_list');
        }
        $zooInfo = $this->zooController->index();
        $sliders = $this->sliderController->sliders_in_home_page();

        return $this->render('user/new.html.twig', [
            'form' => $form->createView(),
            'zooInfo' => $zooInfo,
            'sliders' => $sliders,
        ]);
    }

    
    #[Route('/admin/list', name: '_list')]
    public function listUsers(EntityManagerInterface $entityManager): Response
    {
        $this->denyAccessUnlessGranted('ROLE_ADMIN');

        $users = $entityManager->getRepository(User::class)->findAll();
        $zooInfo = $this->zooController->index();
        $sliders = $this->sliderController->sliders_in_home_page();
        return $this->render('user/list.html.twig', [
            'users' => $users,
            'zooInfo' => $zooInfo,
            'sliders' => $sliders,
            
        ]);
    }
}
