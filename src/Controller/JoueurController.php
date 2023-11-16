<?php

namespace App\Controller;
use App\Entity\Joueur;
use App\Entity\Vote ; 
use App\Repository\VoteRepository ;
use App\Repository\JoueurRepository ; 
use App\Form\JoueurType;
use App\Form\VoteType;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\Form\FormBuilderInterface;

use phpDocumentor\Reflection\DocBlock\Tags\Throws;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\ORM\EntityManagerInterface;


class JoueurController extends AbstractController
{
    #[Route('/joueur', name: 'app_joueur')]
    public function index(): Response
    {
        return $this->render('joueur/index.html.twig', [
            'controller_name' => 'JoueurController',
        ]);
    }

    #[Route('/JoueurAdd', name: 'JoueurAdd')]
    public function JoueurAdd(ManagerRegistry $manager, Request $request): Response
    {
        $em = $manager->getManager();
        $joueur = new Joueur();
        $form = $this->createForm(JoueurType::class, $joueur);
        $form->handleRequest($request);
    
        if ($form->isSubmitted()) {
            $em->persist($joueur);
            $em->flush();
            return $this->redirectToRoute('list_JoueurDB'); 
        }
        return $this->renderForm('joueur/addJouer.html.twig', ['form' => $form]);
    }
    #[Route('/listJoueur', name: 'list_JoueurDB')]
    public function listJoueur(JoueurRepository $Joueurepository): Response
    {
        return $this->render('joueur/listJoueur.html.twig', [
            'Joueurs' => $Joueurepository->findAll(),
        ]);
    }
  
    #[Route('/vote', name: 'Joueur_vote')]
    public function author_vote(ManagerRegistry $manager, Request $request , JoueurRepository $j ): Response
    {
        $em = $manager->getManager();
        $vote = new Vote();
        $vote->setDate(new \DateTime());
        $form = $this->createForm(VoteType::class, $vote);
        $form->handleRequest($request);
       
    
        if ($form->isSubmitted()) {
            $joueurvote=$vote->getJouerVote() ; 
            $vote->setMoyenneVote($j->getSommeVoteByJoueur($joueurvote->getId())) ; 
            $em->persist($vote);
            $em->flush();
            return $this->redirectToRoute('list_JoueurDB'); 
        }
        return $this->renderForm('joueur/addVote.html.twig', ['form' => $form]);
    }

    #[Route('/details/{id}', name: 'author_details')]
    public function author_details(VoteRepository $repository, $id, JoueurRepository $repo): Response
    {

        $votes = $repository->getVotesByJoueur($id);
        $joueur = $repo->find($id);
    
        return $this->render('joueur/votesByJoueur.html.twig', [
            'votes' => $votes,
            'joueur' => $joueur,
        ]);
    }
    
  
    
}
