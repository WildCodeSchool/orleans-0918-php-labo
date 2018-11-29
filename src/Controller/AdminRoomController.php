<?php

namespace App\Controller;

use App\Repository\RoomRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Room;

class AdminRoomController extends AbstractController
{
    /**
     * @Route("/admin/salle", name="admin_room")
     */
    public function indexRoom(RoomRepository $roomRepository):Response
    {
        return $this->render('admin/indexRoom.html.twig', [
            'rooms' => $roomRepository->findAll(),
        ]);
    }
}
