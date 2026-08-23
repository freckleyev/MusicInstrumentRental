<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class BlockedUserController extends AbstractController
{
    #[Route('/blocked', name: 'app_blocked_user')]
    public function index(): Response
    {
        return $this->render('blocked_user/index.html.twig');
    }
}
