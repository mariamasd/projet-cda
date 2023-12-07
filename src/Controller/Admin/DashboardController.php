<?php

namespace App\Controller\Admin;

use App\Entity\RendezVous;
use Doctrine\ORM\EntityManagerInterface;
use EasyCorp\Bundle\EasyAdminBundle\Config\Dashboard;
use EasyCorp\Bundle\EasyAdminBundle\Config\MenuItem;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractDashboardController;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Console\Output\ConsoleOutput;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;

class DashboardController extends AbstractController
{
    #[IsGranted('ROLE_PATIENT')] 
    #[Route('/admin', name: 'admin')]
    public function index(EntityManagerInterface $entityManager): Response
    {


        $donnees = $entityManager->getRepository(RendezVous::class)->findAll();
        $consoleOutput = new ConsoleOutput();

        foreach ($donnees as $item) {
            $consoleOutput->writeln('Date: ' . $item->getDateRV()->format('Y-m-d H:i:s'));
            $consoleOutput->writeln('Status: ' . $item->getStatus());
            $consoleOutput->writeln('--------------');
        }


        $consoleOutput->writeln('Hello, Symfony console!');
        // Make sure the user is authenticated
        if (!$this->getUser()) {
            throw $this->createAccessDeniedException('This user does not have access to the admin dashboard.');
        }

        return $this->render('user/index.html.twig', [
            'user' => $this->getUser(),
            'donnees' => $donnees,
        ]);
        // return parent::index();
        

        // Option 1. You can make your dashboard redirect to some common page of your backend
        //
        // $adminUrlGenerator = $this->container->get(AdminUrlGenerator::class);
        // return $this->redirect($adminUrlGenerator->setController(OneOfYourCrudController::class)->generateUrl());

        // Option 2. You can make your dashboard redirect to different pages depending on the user
        //
        // if ('jane' === $this->getUser()->getUsername()) {
        //     return $this->redirect('...');
        // }

        // Option 3. You can render some custom template to display a proper dashboard with widgets, etc.
        // (tip: it's easier if your template extends from @EasyAdmin/page/content.html.twig)
        //
        // return $this->render('some/path/my-dashboard.html.twig');
    }
    public function app(SessionInterface $session): Response
    {
            // Récupération des données depuis la session
            $donnees = $session->get('donnees', []);
            dd($donnees);
            // Affichage des données dans la vue
            return $this->render('user/index.html.twig', ['donnees' => $donnees]);
    dd($donnees);

    }

    public function configureDashboard(): Dashboard
    {
        return Dashboard::new()
            ->setTitle('Labo');
    }

    public function configureMenuItems(): iterable
    {
        yield MenuItem::linkToDashboard('Dashboard', 'fa fa-home');
        // yield MenuItem::linkToCrud('The Label', 'fas fa-list', EntityClass::class);
    }
}