<?php

namespace App\Controller; 

use App\Repository\InstrumentsRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class PublicController extends AbstractController
{
    #[Route('/', name: 'app_home')]
    public function index(
        InstrumentsRepository $instrumentsRepository
    ): Response {
        $instruments = $instrumentsRepository->findAll();

        return $this->render('home/index.html.twig', [
            'instruments' => $instruments,
        ]);
    }
}
