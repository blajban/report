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

class ReportController extends AbstractController
{
    /**
     * @Route("/")
     */
    public function main(): Response
    {
        return $this->render('report.html.twig', [
            'title' => "Main",
            'heading' => "Välkommen",
            'content' => parseMarkdown('me.md')
        ]);
    }

    /**
     * @Route("/about")
     */
    public function about(): Response
    {
        return $this->render('report.html.twig', [
            'title' => "About",
            'heading' => "DV1608",
            'content' => parseMarkdown('mvc.md')
        ]);
    }

    /**
     * @Route("/report")
     */
    public function report(): Response
    {
        return $this->render('report.html.twig', [
            'title' => "Report",
            'heading' => "Redovisning",
            'content' => parseMarkdown('report.md')
        ]);
    }

    /**
     * @route("/lucky")
     */
    public function lucky(): Response
    {
        $number = random_int(0, 100);

        return $this->render('report.html.twig', [
            'title' => "Lucky!",
            'heading' => "Lucky!",
            'content' => $number
        ]);
    }
}
