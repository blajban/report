<?php

namespace App\Controller;

use App\Entity\RoomInfo;
use App\Proj\AdventureGame;
use App\Proj\Map;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Exception;
use Symfony\Component\HttpFoundation\Request;

use App\Repository\RoomInfoRepository;

use App\Services\UtilityService;


class ProjJsonController extends AbstractController
{
    private UtilityService $utilityService;

    public function __construct(UtilityService $utilityService)
    {
        $this->utilityService = $utilityService;
    }

    #[Route("/proj/api/roominfo", methods: ['GET'])]
    public function allRoomInfo(RoomInfoRepository $roomInfoRepository): Response
    {
        $allRoomInfo = $roomInfoRepository->findAll();

        $jsonRoomInfo = [];

        foreach ($allRoomInfo as $roomInfo) {
            $jsonRoomInfo[] =  [
                'id' => $roomInfo->getId(),
                'name' => $roomInfo->getName(),
                'description' => $roomInfo->getDescription(),
                /** @phpstan-ignore-next-line */
                'img' => $roomInfo->getImg() ? base64_encode(stream_get_contents($roomInfo->getImg())) : null,
            ];
        }
        return $this->json($jsonRoomInfo, 200, [], [
            'json_encode_options' => JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES
        ]);
    }

    #[Route("/proj/api/roominfo/add", methods: ['POST'])]
    public function addRoomInfo(Request $request, RoomInfoRepository $roomInfoRepository): Response
    {
        $jsonData = $request->request->get('json_data');
        $data = json_decode($jsonData, true);

        /** @var UploadedFile|null $pictureFile */
        $pictureFile = $request->files->get('img');
        $picture = $this->utilityService->generatePictureDataFromUploaded($pictureFile);


        $roomInfo = new RoomInfo();
        $roomInfo->setName($data['name']);
        $roomInfo->setDescription($data['description']);
        $roomInfo->setImg($picture);


        $roomInfoRepository->save($roomInfo, true);

        return new Response('Added room info', Response::HTTP_CREATED);
    }

    #[Route("/proj/api/roominfo/delete", methods: ['POST'])]
    public function deleteRoomInfo(Request $request, RoomInfoRepository $roomInfoRepository): Response
    {
        $id = $request->request->get('id');
        $roomInfo = $roomInfoRepository->find($id);
        $roomInfoRepository->remove($roomInfo, true);

        return new Response('Room info removed', Response::HTTP_OK);
    }





}
