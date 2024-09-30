<?php

namespace App\Controller;

use App\Repository\ReportDeSanteRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ReportDeSanteController extends AbstractController
{
    public function __construct(
        private ReportDeSanteRepository $repository,
        private ZooController $zooController,
        private SliderController $sliderController,)
    {
    }

    #[Route('/reportDeSante', name: 'app_report_de_sante')]
    public function index(): Response
    {
        $report= $this->repository->findAll();
        return $this->render('report_de_sante/index.html.twig', [
            'report' => $report,
        ]);
    }
}
