<?php

namespace App\Controller\Admin;

use App\Entity\Candidate;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Controller\Admin\CandidateCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Config\MenuItem;
use EasyCorp\Bundle\EasyAdminBundle\Config\Dashboard;
use EasyCorp\Bundle\EasyAdminBundle\Router\AdminUrlGenerator;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractDashboardController;

class DashboardController extends AbstractDashboardController
{
    /**
     * @Route("/admin", name="admin")
     */
    public function index(): Response
    {
        $routeBuilder = $this->get(AdminUrlGenerator::class);

        return $this->redirect($routeBuilder->setController(CandidateCrudController::class)->generateUrl());
    }

    public function configureDashboard(): Dashboard
    {
        return Dashboard::new()
            ->setTitle('Dashboard Talent Factory ');
    }

    public function configureMenuItems(): iterable
    {
        return [
            yield MenuItem::Section('Dashboard', 'fa fa-home'),
        
            yield MenuItem::section('Talent Factory'),
            yield MenuItem::linkToCrud('Candidate', 'fa fa-tags', Candidate::class)
        ];
    }
}
