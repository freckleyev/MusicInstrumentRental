<?php

namespace App\Controller\Dashboard;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use App\Repository\InstrumentsRepository;
use App\Repository\UserRepository;
use App\Repository\CategoriesRepository;
use App\Repository\RentalRequestsRepository;
use Symfony\Component\Routing\Attribute\Route;

final class DashboardController extends AbstractController
{
    #[Route('/dashboard', name: 'app_dashboard')]
    public function index(InstrumentsRepository $instrumentsRepository, UserRepository $userRepository, CategoriesRepository $categoriesRepository, RentalRequestsRepository $rentalRequestsRepository): Response
    {
        return $this->render('dashboard/dashboard.html.twig', [
            'instrumentsCount' => $instrumentsRepository->count([]),
            'availableInstrumentsCount' => $instrumentsRepository->count(['is_active' => 1]),
            'userCount' => $userRepository->count([]),
            'categoriesCount' => $categoriesRepository->count([]),
            'pendingRequestsCount' => $rentalRequestsRepository->count(['status' => 'pending']),
            'rejectedRequestsCount' => $rentalRequestsRepository->count(['status' => 'rejected']),
            'approvedRequestsCount' => $rentalRequestsRepository->count(['status' => 'approved']),
            'completedRequestsCount' => $rentalRequestsRepository->count(['status' => 'completed']),
        ]);
    }

}
