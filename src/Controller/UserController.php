<?php

namespace App\Controller;

use App\Form\ProfileType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class UserController extends AbstractController
{
    #[Route('/profile', name: 'app_profile')]
    public function profile(
        Request $request,
        EntityManagerInterface $entityManager
    ): Response {
        $this->denyAccessUnlessGranted('ROLE_USER');

        $user = $this->getUser();

        $form = $this->createForm(ProfileType::class, $user);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            $this->addFlash('success', 'Your profile has been updated successfully.');

            return $this->redirectToRoute('app_profile');
        }

        return $this->render('user/profile.html.twig', [
            'form' => $form,
        ]);
    }
}
