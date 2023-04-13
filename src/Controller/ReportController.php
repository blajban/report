<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Parsedown;

function parseMarkdown($fileName): string
{
    $parseDown = new Parsedown();
    $content = file_get_contents('../assets/content/' . $fileName);
    return $parseDown->text($content);
}

function jsonResponse($data): Response
{
    $response = new Response();
    $response->setContent(json_encode($data));
    $response->headers->set('Content-Type', 'application/json');

    return $response;
}

class ReportController extends AbstractController
{
    #[Route("/", name: "home")]
    public function main(): Response
    {
        return $this->render('report_1col.html.twig', [
            'title' => "Main",
            'heading' => "Välkommen",
            'content' => parseMarkdown('me.md')
        ]);
    }

    #[Route("/about", name: "about")]
    public function about(): Response
    {
        return $this->render('report_2col.html.twig', [
            'title' => "About",
            'heading' => "DV1608",
            'contentLeft' => parseMarkdown('mvc-left.md'),
            'contentRight' => parseMarkdown('mvc-right.md')
        ]);
    }

    #[Route("/report", name: "report")]
    public function report(): Response
    {
        return $this->render('report_1col.html.twig', [
            'title' => "Report",
            'heading' => "Redovisning",
            'content' => parseMarkdown('report.md')
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

        return $this->render('report_1col_nohero.html.twig', [
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

        return jsonResponse($res);
    }
}
