<?php

namespace App\Controller\Dashboard;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use App\Repository\RentalRequestsRepository;
use App\Entity\RentalRequests;
use App\Enum\RentalRequestStatus;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\HttpFoundation\Request;

#[Route('dashboard')]
final class AdminRentalRequestController extends AbstractController
{
    #[Route('/rental', name: 'app_admin_rental_request', methods: ['GET'])]
    public function index(RentalRequestsRepository $rentalRequestsRepository): Response
    {
        $sortBy = "createdAt";
        $sortDirection = "DESC";
        $rentalRequest = $rentalRequestsRepository->sort($sortBy, $sortDirection);

        return $this->render('dashboard/admin_rental_request/index.html.twig', [
            'rental_requests' => $rentalRequest,
        ]);
    }

    #[Route('/rental/{id}/status-update', name: 'app_admin_rental_request_status_update', methods: ['GET', 'POST'])]
    public function statusUpdate(RentalRequests $rentalRequest, Request $request, EntityManagerInterface $entityManager): Response {
        if ($request->isMethod('POST')) {
            // Verify CSRF token for security
            if (!$this->isCsrfTokenValid('status_update_' . $rentalRequest->getId(), $request->request->get('_token'))) {
                $this->addFlash('danger', 'Invalid security token.');
                return $this->redirectToRoute('app_admin_rental_request_status_update', ['id' => $rentalRequest->getId()]);
            }

            $action = $request->request->get('action');
            $now = new \DateTimeImmutable();
            $currentUser = $this->getUser();

            if ($action === 'approve' && $rentalRequest->getStatus() === RentalRequestStatus::PENDING) {
                $rentalRequest->setStatus(RentalRequestStatus::APPROVED);
                $rentalRequest->setReviewedBy($currentUser);
                $rentalRequest->setUpdatedAt($now);
                $this->addFlash('success', 'Rental request has been approved.');

            } elseif ($action === 'reject' && $rentalRequest->getStatus() === RentalRequestStatus::PENDING) {
                $reason = trim($request->request->get('rejection_reason', ''));
                $rentalRequest->setStatus(RentalRequestStatus::REJECTED);
                $rentalRequest->setRejectionReason($reason);
                $rentalRequest->setReviewedBy($currentUser);
                $rentalRequest->setUpdatedAt($now);
                $this->addFlash('danger', 'Rental request has been rejected.');

            } elseif ($action === 'complete' && $rentalRequest->getStatus() === RentalRequestStatus::APPROVED) {
                $rentalRequest->setStatus(RentalRequestStatus::COMPLETED);
                $rentalRequest->setReviewedBy($currentUser);
                $rentalRequest->setUpdatedAt($now);
                $this->addFlash('info', 'Rental request marked as completed.');
            }

            $entityManager->flush();

            return $this->redirectToRoute('app_admin_rental_request');
        }

        return $this->render('dashboard/admin_rental_request/status_update.html.twig', [
            'rentalRequest' => $rentalRequest,
        ]);
    }

}
