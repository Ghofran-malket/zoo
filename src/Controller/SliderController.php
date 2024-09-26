<?php

namespace App\Controller;

use App\Repository\SliderRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class SliderController extends AbstractController
{
    public function __construct(
        private SliderRepository $repository)
    {
    }

    public function sliders_in_home_page()
    {
        return $this->repository->findBy([], null, 3);
    }
}
