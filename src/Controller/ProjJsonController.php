<?php

namespace App\Controller;

use App\Entity\Item;
use App\Entity\Room;
use App\Proj\AdventureGame;
use App\Proj\Map;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Exception;
use Symfony\Component\HttpFoundation\Request;

use App\Repository\RoomRepository;
use App\Repository\ItemRepository;

use App\Services\UtilityService;

/**
 * @SuppressWarnings(PHPMD.ShortVariable)
 */
class ProjJsonController extends AbstractController
{
    private UtilityService $utilityService;

    public function __construct(UtilityService $utilityService)
    {
        $this->utilityService = $utilityService;
    }

    #[Route("/proj/api/room", methods: ['GET'])]
    public function allRooms(RoomRepository $roomRepository): Response
    {
        $allRooms = $roomRepository->findAll();

        $jsonRooms = [];

        foreach ($allRooms as $room) {
            $jsonRooms[] =  [
                'id' => $room->getId(),
                'name' => $room->getName(),
                'description' => $room->getDescription(),
                /** @phpstan-ignore-next-line */
                'img' => $room->getImg() ? base64_encode(stream_get_contents($room->getImg())) : null,
            ];
        }
        return $this->json($jsonRooms, 200, [], [
            'json_encode_options' => JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES
        ]);
    }

    #[Route("/proj/api/room/add", methods: ['POST'])]
    public function addRoom(Request $request, RoomRepository $roomRepository): Response
    {
        $jsonData = (string)$request->request->get('json_data');

        $data = json_decode($jsonData, true);

        if (!is_array($data)) {
            return new Response('Invalid JSON data', Response::HTTP_BAD_REQUEST);
        }

        if (!isset($data['name']) || !isset($data['description'])) {
            return new Response('Missing required fields', Response::HTTP_BAD_REQUEST);
        }

        /** @var UploadedFile|null $pictureFile */
        $pictureFile = $request->files->get('img');
        $picture = null;
        if ($pictureFile) {
            $picture = $this->utilityService->generatePictureDataFromUploaded($pictureFile);
        }

        $room = new Room();
        $room->setName($data['name']);
        $room->setDescription($data['description']);
        $room->setImg($picture);


        $roomRepository->save($room, true);

        return new Response('Added room info', Response::HTTP_CREATED);
    }

    #[Route("/proj/api/room/delete", methods: ['POST'])]
    public function deleteRoom(Request $request, RoomRepository $roomRepository): Response
    {
        $id = $request->request->get('id');
        $room = $roomRepository->find($id);

        if ($room) {
            $roomRepository->remove($room, true);
            return new Response('Room info removed', Response::HTTP_OK);
        }

        return new Response('Room not found', Response::HTTP_BAD_REQUEST);
    }

    #[Route("/proj/api/item", methods: ['GET'])]
    public function allItems(ItemRepository $itemRepository): Response
    {
        $allItems = $itemRepository->findAll();

        $jsonItems = [];

        foreach ($allItems as $item) {
            $jsonItems[] =  [
                'id' => $item->getId(),
                'name' => $item->getName(),
                'description' => $item->getDescription(),
            ];
        }
        return $this->json($jsonItems, 200, [], [
            'json_encode_options' => JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES
        ]);
    }

    #[Route("/proj/api/item/add", methods: ['POST'])]
    public function addItem(Request $request, ItemRepository $itemRepository): Response
    {
        $jsonData = $request->getContent();

        if (!is_string($jsonData)) {
            return new Response('Invalid input', Response::HTTP_BAD_REQUEST);
        }

        $data = json_decode($jsonData, true);

        if (!is_array($data)) {
            return new Response('Invalid JSON data', Response::HTTP_BAD_REQUEST);
        }

        if (!isset($data['name']) || !isset($data['description'])) {
            return new Response('Missing required fields', Response::HTTP_BAD_REQUEST);
        }

        $item = new Item();
        $item->setName($data['name']);
        $item->setDescription($data['description']);

        $itemRepository->save($item, true);

        return new Response('Added item', Response::HTTP_CREATED);
    }

    #[Route("/proj/api/item/delete", methods: ['POST'])]
    public function deleteItem(Request $request, ItemRepository $itemRepository): Response
    {
        $id = $request->request->get('id');
        $item = $itemRepository->find($id);

        if ($item) {
            $itemRepository->remove($item, true);
            return new Response('Item removed', Response::HTTP_OK);
        }

        return new Response('Item not found', Response::HTTP_BAD_REQUEST);

    }





}
