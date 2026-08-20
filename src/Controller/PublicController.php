<?php

namespace App\Controller;

use App\Repository\CategoriesRepository;
use App\Repository\InstrumentsRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class PublicController extends AbstractController
{
    #[Route('/', name: 'app_public')]
    public function index(
        Request $request,
        InstrumentsRepository $instrumentsRepository,
        CategoriesRepository $categoriesRepository
    ): Response {
        $search = $request->query->get('search');
        $categoryId = $request->query->get('category');

        $instruments = $instrumentsRepository->findForGuest(
            $search,
            $categoryId
        );

        $categories = $categoriesRepository->findAll();

        return $this->render('public/index.html.twig', [
            'instruments' => $instruments,
            'categories' => $categories,
            'search' => $search,
            'selectedCategory' => $categoryId,
        ]);
    }
}