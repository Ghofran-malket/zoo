<?php

namespace App\Controller;

use App\Repository\OpinionRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class OpinionController extends AbstractController
{
    public function __construct(
        private OpinionRepository $repository,)
    {
    }

    public function opinions_in_home_page()
    {
        return $this->repository->findBy([], null, 2);
    }
}
