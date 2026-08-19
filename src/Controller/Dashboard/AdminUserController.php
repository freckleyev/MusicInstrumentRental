<?php

namespace App\Controller\Dashboard;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use App\Repository\UserRepository;
use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('dashboard')]
final class AdminUserController extends AbstractController
{
    #[Route('/user', name: 'app_admin_user', methods: ['GET'])]
    public function index(UserRepository $userRepository): Response
    {
        return $this->render('dashboard/admin_user/index.html.twig', [
            'users' => $userRepository->findAll(),
        ]);
    }

    #[Route('/user/{id}/toggle-block', name: 'app_admin_user_toggle_block', methods: ['POST'])]
    public function toggleBlock(User $user, EntityManagerInterface $entityManager, Request $request): Response {

        if (!$this->isCsrfTokenValid('toggle_block_' . $user->getId(), $request->request->get('_token'))) {
            $this->addFlash('danger', 'Invalid CSRF token.');
            return $this->redirectToRoute('app_admin_user');
        }

        if (in_array('ROLE_ADMIN', $user->getRoles(), true) && !$user->isBlocked()) {
            $this->addFlash('danger', 'Admin users cannot be blocked.');
            return $this->redirectToRoute('app_admin_user');
        }

        $user->setIsBlocked(!$user->isBlocked());
        $entityManager->flush();

        $action = $user->isBlocked() ? 'blocked' : 'unblocked';
        $this->addFlash('success', sprintf('User %s has been %s.', $user->getEmail(), $action));

        return $this->redirectToRoute('app_admin_user');
    }
}
