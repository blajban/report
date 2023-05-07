<?php

namespace App\Services;

use Symfony\Component\HttpFoundation\JsonResponse;
use Parsedown;
use phpDocumentor\Reflection\Types\Resource_;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\File\UploadedFile;

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

    public function generatePictureDataFromUploaded(UploadedFile $pictureFile): string|false
    {
        return file_get_contents($pictureFile->getPathname());
    }

    public function generatePictureDataFromFile(string $pictureFilePath): string|false
    {
        if (file_exists($pictureFilePath)) {
            return file_get_contents($pictureFilePath);
        }

        return false;
    }

    /** @phpstan-ignore-next-line */
    public function imageResponse($pictureBlob): Response
    {
        /** @var string $pictureData */
        $pictureData = stream_get_contents($pictureBlob);

        $response = new Response($pictureData);
        $response->headers->set('Content-Type', 'image');

        return $response;
    }
}
