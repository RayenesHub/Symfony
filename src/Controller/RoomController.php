<?php

namespace App\Controller;

use App\Entity\Room;
use App\Form\RoomType;
use App\Repository\RoomRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class RoomController extends AbstractController
{
    #[Route('/room', name: 'app_room')]
    public function index(): Response
    {
        return $this->render('room/index.html.twig', [
            'controller_name' => 'RoomController',
        ]);
    }

    #[Route('/room/show', name: 'room_show')]
    public function show(RoomRepository $rep): Response
    {
        $room=$rep->orderbyname();
       // $room = $rep->findAll();
        return $this->render('/room/roomlist.html.twig', ['room'=>$room]);
    }
     




    #[Route('/addformroom', name: 'room_add')]
    public function addformroom(ManagerRegistry $managerRegistry, Request $req): Response
    {
        $x = $managerRegistry->getManager();
        $room = new Room();
        $form = $this->createForm(RoomType::class, $room);
        $form->handleRequest($req);
        if ($form->isSubmitted() and $form->isValid()) {
            $x->persist($room);
            $x->flush();

            return $this->redirectToRoute('room_show');
        }
        return $this->renderForm('/room/addformroom.html.twig', [
            'f' => $form
        ]);
    }






    #[Route('/room/update/{id}', name: 'room_update')]
    public function UpdateRoom(ManagerRegistry $doctrine, Request $request, RoomRepository $rep, $id): Response
    {
       $room = $rep->find($id);
       $form=$this->createForm(RoomType::class,$room);
       $form->handleRequest($request);
       if($form->isSubmitted()){
           $em= $doctrine->getManager();
           $em->persist($room);
           $em->flush();
           return $this-> redirectToRoute('room_show');
       }
       return $this->render('/room/addformroom.html.twig',[
           'f'=>$form->createView(),
       ]);
    }








    #[Route('/room/delete/{id}', name: 'room_delete')]
     public function deleteRoom($id, RoomRepository $rep, ManagerRegistry $doctrine): Response
     {
         $em= $doctrine->getManager();
         $room= $rep->find($id);
         $em->remove($room);
         $em->flush();
         return $this-> redirectToRoute('room_show');
     }

}
