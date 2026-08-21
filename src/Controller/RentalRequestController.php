<?php

namespace App\Controller;

use App\Entity\Instruments;
use App\Entity\RentalRequests;
use App\Enum\RentalRequestStatus;
use App\Form\RentalRequestType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class RentalRequestController extends AbstractController
{
    #[Route('/instrument/{id}/rent', name: 'app_rental_request_new', methods: ['GET', 'POST'])]
    public function new(
        Instruments $instrument,
        Request $request,
        EntityManagerInterface $entityManager
    ): Response {
        // Only logged-in users can make rental requests
        $this->denyAccessUnlessGranted('ROLE_USER');

// Check if the instrument is available
if (!$instrument->isActive()) {
    $this->addFlash(
        'danger',
        'This instrument is currently not available.'
    );

    return $this->redirectToRoute('app_public');
}

// Create a new rental request
$rentalRequest = new RentalRequests();
        // Create a new rental request
        $rentalRequest = new RentalRequests();

        // Connect the request to the logged-in user
        $rentalRequest->setUser($this->getUser());

        // Connect the request to the selected instrument
        $rentalRequest->setInstrument($instrument);

        // Set the initial status
        $rentalRequest->setStatus(RentalRequestStatus::PENDING);

        // Set creation date
        $rentalRequest->setCreatedAt(new \DateTimeImmutable());

        // Create the form
        $form = $this->createForm(RentalRequestType::class, $rentalRequest);

        // Process the form
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $entityManager->persist($rentalRequest);
            $entityManager->flush();

            return $this->redirectToRoute('app_rental_request_success');
        }

        return $this->render('rental_request/new.html.twig', [
            'form' => $form,
            'instrument' => $instrument,
        ]);
    }

    #[Route('/rental-request/success', name: 'app_rental_request_success', methods: ['GET'])]
    public function success(): Response
    {
        $this->denyAccessUnlessGranted('ROLE_USER');

        return $this->render('rental_request/success.html.twig');
    }
}