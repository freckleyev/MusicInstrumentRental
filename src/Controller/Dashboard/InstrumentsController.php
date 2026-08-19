<?php

namespace App\Controller\Dashboard;

use App\Entity\Instruments;
use App\Form\InstrumentsType;
use App\Repository\InstrumentsRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('dashboard/instruments')]
final class InstrumentsController extends AbstractController
{
    #[Route(name: 'app_instruments_index', methods: ['GET'])]
    public function index(InstrumentsRepository $instrumentsRepository): Response
    {
        return $this->render('dashboard/instruments/index.html.twig', [
            'instruments' => $instrumentsRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_instruments_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $instrument = new Instruments();
        $form = $this->createForm(InstrumentsType::class, $instrument);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($instrument);
            $entityManager->flush();

            return $this->redirectToRoute('app_instruments_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('dashboard/instruments/new.html.twig', [
            'instrument' => $instrument,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_instruments_show', methods: ['GET'])]
    public function show(Instruments $instrument): Response
    {
        return $this->render('dashboard/instruments/show.html.twig', [
            'instrument' => $instrument,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_instruments_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Instruments $instrument, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(InstrumentsType::class, $instrument);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_instruments_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('dashboard/instruments/edit.html.twig', [
            'instrument' => $instrument,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_instruments_delete', methods: ['POST'])]
    public function delete(Request $request, Instruments $instrument, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$instrument->getId(), $request->getPayload()->getString('_token'))) {
            $entityManager->remove($instrument);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_instruments_index', [], Response::HTTP_SEE_OTHER);
    }
}
