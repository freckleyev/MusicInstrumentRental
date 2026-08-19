<?php

namespace App\Controller\Dashboard;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('dashboard')]
final class AdminRentalRequestController extends AbstractController
{
    #[Route('/rental', name: 'app_admin_rental_request')]
    public function index(): Response
    {
        return $this->render('dashboard/admin_rental_request/index.html.twig', [
            'controller_name' => 'AdminRentalRequestController',
        ]);
    }
}
