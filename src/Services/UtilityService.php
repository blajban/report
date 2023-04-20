<?php

namespace App\Services;

use Symfony\Component\HttpFoundation\JsonResponse;
use Parsedown;

class UtilityService
{
    public function parseMarkdown(string $fileName): string
    {
        $parseDown = new Parsedown();
        $content = file_get_contents('../assets/content/' . $fileName);
        return $parseDown->text($content);
    }

    public function jsonResponse(Mixed $data): JsonResponse
    {
        $response = new JsonResponse($data);
        $response->setEncodingOptions(
            $response->getEncodingOptions() | JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES
        );

        return $response;
    }
}
