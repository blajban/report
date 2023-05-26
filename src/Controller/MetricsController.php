<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Services\UtilityService;

class MetricsController extends AbstractController
{
    private UtilityService $utilityService;

    public function __construct(UtilityService $utilityService)
    {
        $this->utilityService = $utilityService;
    }

    #[Route("/metrics", name: "metrics", methods: ['GET'])]
    public function libraryLanding(): Response
    {
        return $this->render('1col_nohero.html.twig', [
            'title' => "Metrics",
            'heading' => "Metrics",
            'content' => $this->utilityService->parseMarkdown('metrics.md')
        ]);
    }

}
