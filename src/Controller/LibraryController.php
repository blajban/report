<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Exception;
use Symfony\Component\HttpFoundation\Request;


use App\Services\UtilityService;

class LibraryController extends AbstractController
{
    private UtilityService $utilityService;

    public function __construct(UtilityService $utilityService)
    {
        $this->utilityService = $utilityService;
    }

    #[Route("/library", name: "library", methods: ['GET'])]
    public function game(): Response
    {
        return $this->render('library/library_start.html.twig', [
            'title' => "Bibliotek",
            'heading' => "Bibliotek",
            'content' => $this->utilityService->parseMarkdown('library.md')
        ]);
    }
}
