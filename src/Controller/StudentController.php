<?php

namespace App\Controller;

use App\Entity\Room;
use App\Entity\Student;
use App\Form\SearchStudentType;
use App\Form\StudentType;
use App\Repository\StudentRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class StudentController extends AbstractController
{
    #[Route('/student', name: 'app_student')]
    public function index(): Response
    {
        return $this->render('student/index.html.twig', [
            'controller_name' => 'StudentController',
        ]);
    }



    #[Route('/student/show', name: 'student_show')]
    public function show(StudentRepository $rep , Request $req): Response
    {
        $student=$rep->orderbyroom();
       // $student = $rep->findAll();
       $form = $this->createForm(SearchStudentType::class);
       $form->handleRequest($req);
       if($form->isSubmitted())
       {
        $datainput = $form->get('Room')->getData();
        $studentnew = $rep->searchstudent($datainput);
        return $this->renderForm('/student/studentlist.html.twig',
        ['student'=>$studentnew,
        'f'=>$form]);
       }

        return $this->renderForm('/student/studentlist.html.twig', ['student'=>$student,
    'f'=>$form]);
    }
     






    #[Route('/addformstudent', name: 'student_add')]
    public function addformstudent(ManagerRegistry $managerRegistry, Request $req): Response
    {
        $x = $managerRegistry->getManager();
        $student = new Student();
        $form = $this->createForm(StudentType::class, $student);
        $form->handleRequest($req);
        if ($form->isSubmitted() and $form->isValid()) {
            $x->persist($student);
            $x->flush();

            return $this->redirectToRoute('student_show');
        }
        return $this->renderForm('/room/addformroom.html.twig', [
            'f' => $form
        ]);
    }





    #[Route('/student/update/{id}', name: 'student_edit')]
    public function UpdateStudent(ManagerRegistry $doctrine, Request $request, Studentrepository $rep, $id): Response
    {
       $student = $rep->find($id);
       $form=$this->createForm(StudentType::class,$student);
       $form->handleRequest($request);
       if($form->isSubmitted()){
           $em= $doctrine->getManager();
           $em->persist($student);
           $em->flush();
           return $this-> redirectToRoute('student_show');
       }
       return $this->render('/room/addformroom.html.twig',[
           'f'=>$form->createView(),
       ]);
    }







    #[Route('/student/delete/{id}', name: 'student_delete')]
    public function deleteRoom($id, StudentRepository $rep, ManagerRegistry $doctrine): Response
    {
        $em= $doctrine->getManager();
        $student= $rep->find($id);
        $em->remove($student);
        $em->flush();
        return $this-> redirectToRoute('student_show');
    }


}
