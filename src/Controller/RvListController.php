<?php

namespace App\Controller;
use App\Entity\RendezVous;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class RvListController extends AbstractController
{
    #[Route('/rvList', name: 'app_rv')]
    public function index(EntityManagerInterface $entityManager): Response
    {

        $donnees = [
            'dateRV' => new \DateTime('2023-12-10 09:00:00'),
            'status' => 'Scheduled',
            'patient' => 'aaaaa', // Assuming the username is relevant to the patient
        ];

        $rendezVousList = $entityManager->getRepository(RendezVous::class)->findAll();
        return $this->render('user/index.html.twig', [
            'rendezVousList' => $rendezVousList,
            'donnees' => $donnees,
        ]);
    }
}
