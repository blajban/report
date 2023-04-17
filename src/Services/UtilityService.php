<?php

namespace App\Services;

use Symfony\Component\HttpFoundation\Response;
use Parsedown;

class UtilityService
{
    public function parseMarkdown($fileName): string
    {
        $parseDown = new Parsedown();
        $content = file_get_contents('../assets/content/' . $fileName);
        return $parseDown->text($content);
    }

    public function jsonResponse($data): Response
    {
        $response = new Response();
        $response->setContent(json_encode($data));
        $response->headers->set('Content-Type', 'application/json');

        return $response;
    }
}
