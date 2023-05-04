<?php

namespace App\Services;

use Symfony\Component\HttpFoundation\JsonResponse;
use Parsedown;
use Symfony\Component\HttpFoundation\Response;

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

    public function generatePictureDataFromUploaded($pictureFile): string|null
    {
        if ($pictureFile) {
            return file_get_contents($pictureFile->getPathname());
        }

        return null;
    }

    public function generatePictureDataFromFile($pictureFilePath): string|null
    {
        if (file_exists($pictureFilePath)) {
            return file_get_contents($pictureFilePath);
        }

        return null;
    }

    public function imageResponse($pictureBlob)
    {
        $pictureData = stream_get_contents($pictureBlob);

        $response = new Response($pictureData);
        $response->headers->set('Content-Type', 'image');

        return $response;
    }
}
