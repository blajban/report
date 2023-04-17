<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Services\UtilityService;

class ReportController extends AbstractController
{
    private $utilityService;

    public function __construct(UtilityService $utilityService)
    {
        $this->utilityService = $utilityService;
    }

    #[Route("/", name: "home")]
    public function main(): Response
    {
        return $this->render('1col.html.twig', [
            'title' => "Main",
            'heading' => "Välkommen",
            'content' => $this->utilityService->parseMarkdown('me.md')
        ]);
    }

    #[Route("/about", name: "about")]
    public function about(): Response
    {
        return $this->render('2col.html.twig', [
            'title' => "About",
            'heading' => "DV1608",
            'contentLeft' => $this->utilityService->parseMarkdown('mvc-left.md'),
            'contentRight' => $this->utilityService->parseMarkdown('mvc-right.md')
        ]);
    }

    #[Route("/report", name: "report")]
    public function report(): Response
    {
        return $this->render('1col.html.twig', [
            'title' => "Report",
            'heading' => "Redovisning",
            'content' => $this->utilityService->parseMarkdown('report.md')
        ]);
    }

    #[Route("/lucky", name: "lucky")]
    public function lucky(): Response
    {
        $animals = [
            "dog",
            "cat",
            "elephant",
            "cow",
            "horse",
            "frog"
        ];

        $number = random_int(0, count($animals) - 1);

        $animal = $animals[$number];

        return $this->render('1col_nohero.html.twig', [
            'title' => $animal,
            'heading' => $animal,
            'content' => "<img src=\"img/$animal.jpg\">"
        ]);
    }

    #[Route("/api/quote")]
    public function jsonQuote(): Response
    {
        $quotes = [
            "What gets measured gets managed - Peter Drucker",
            "People who count their chickens before they are hatched act very wisely because chickens run about so absurdly that it's impossible to count them accurately - Oscar Wilde",
            "It doesn’t matter what temperature a room is, it’s always room temperature. - Steven Wright"
        ];

        $rand = random_int(0, count($quotes) - 1);

        $res = [
            'quote' => $quotes[$rand],
            'date' => date('Y-m-d'),
            'timestamp' => date('H:i:s')
        ];

        return $this->utilityService->jsonResponse($res);
    }
}
