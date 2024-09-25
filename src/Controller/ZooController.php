<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\ZooRepository;

class ZooController extends AbstractController
{
    public function __construct(private ZooRepository $repository)
    {
    }

    #[Route('/zoo', name: 'app_zoo')]
    public function index()
    {
        return $this->repository->findAll();
    }
}
