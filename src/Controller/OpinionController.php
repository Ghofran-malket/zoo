<?php

namespace App\Controller;

use App\Entity\Opinion;
use App\Form\OpinionType;
use App\Repository\OpinionRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class OpinionController extends AbstractController
{
    public function __construct(
        private OpinionRepository $repository)
    {
    }

    public function opinions_in_home_page()
    {
        return $this->repository->findBy([], null, 2);
    }

}
