<?php

namespace App\Controller;

use App\Entity\RendezVous;
use App\Form\RvType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Routing\Annotation\Route;

class RendezVousController extends AbstractController
{
    #[Route('/rendezVous', name: 'app_rendez_vous')]
    public function register(Request $request, EntityManagerInterface $entityManager, SessionInterface $session): Response
    {
        $rv = new RendezVous();
        $form = $this->createForm(RvType::class, $rv);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($rv);
            $entityManager->flush();

            // Redirect to the list page after successful form submission
            $donnees = $request->request->all();
            $session->set('donnees', $donnees);
    
            // Redirection vers l'action d'affichage du tableau
            return $this->redirectToRoute('admin');
           
        }

        return $this->render('rendez_vous/index.html.twig', [
            'form' => $form->createView(),
        ]);
    }

   
    
    // ...
}

