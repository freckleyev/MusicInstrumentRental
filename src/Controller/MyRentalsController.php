<?php

namespace App\Controller;

use App\Entity\RentalRequests;
use App\Enum\RentalRequestStatus;
use App\Repository\RentalRequestsRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class MyRentalsController extends AbstractController
{
    #[Route('/my-rentals', name: 'app_my_rentals')]
    public function index(
        RentalRequestsRepository $rentalRequestsRepository
    ): Response {
        // Only logged-in users can access My Rentals
        $this->denyAccessUnlessGranted('ROLE_USER');

        // Get the currently logged-in user
        $user = $this->getUser();

        // Find only this user's rental requests
        $rentalRequests = $rentalRequestsRepository->findBy(
            ['user' => $user],
            ['createdAt' => 'DESC']
        );

        return $this->render('my_rentals/index.html.twig', [
            'rentalRequests' => $rentalRequests,
        ]);
    }


    #[Route(
        '/my-rentals/{id}/cancel',
        name: 'app_my_rental_cancel',
        methods: ['POST']
    )]
    public function cancel(
        RentalRequests $rentalRequest,
        Request $request,
        EntityManagerInterface $entityManager
    ): Response {
        // Only logged-in users can cancel rentals
        $this->denyAccessUnlessGranted('ROLE_USER');

        // Make sure the rental belongs to the logged-in user
        if ($rentalRequest->getUser() !== $this->getUser()) {
            throw $this->createAccessDeniedException();
        }

        // Only pending requests can be canceled
        if ($rentalRequest->getStatus() !== RentalRequestStatus::PENDING) {
            $this->addFlash(
                'danger',
                'Only pending rental requests can be canceled.'
            );

            return $this->redirectToRoute('app_my_rentals');
        }

        // Check CSRF token
        if (!$this->isCsrfTokenValid(
            'cancel' . $rentalRequest->getId(),
            $request->request->get('_token')
        )) {
            throw $this->createAccessDeniedException();
        }

        // Change status to canceled
        $rentalRequest->setStatus(RentalRequestStatus::CANCELED);

        // Save the change
        $entityManager->flush();

        // Show success message
        $this->addFlash(
            'success',
            'Your rental request has been canceled.'
        );

        return $this->redirectToRoute('app_my_rentals');
    }
}