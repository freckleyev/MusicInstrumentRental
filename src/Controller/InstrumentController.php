<?php

namespace App\Controller;

use App\Entity\Instruments;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/instrument')]
class InstrumentController extends AbstractController
{
    #[Route('/{id}', name: 'app_instrument_show', methods: ['GET'])]
    public function show(Instruments $instrument): Response
    {
        return $this->render('instrument/show.html.twig', [
            'instrument' => $instrument,
        ]);
    }
}