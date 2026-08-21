<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\RegistrationFormType;
use App\Service\FileUploader;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Attribute\Route;

class RegistrationController extends AbstractController
{
    #[Route('/register', name: 'app_register')]
    public function register(
        Request $request,
        UserPasswordHasherInterface $userPasswordHasher,
        EntityManagerInterface $entityManager,
        FileUploader $fileUploader
    ): Response {

        $user = new User();

        $form = $this->createForm(
            RegistrationFormType::class,
            $user
        );

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            // Get the password entered by the user
            $plainPassword = $form->get('plainPassword')->getData();

            // Hash the password before saving it
            $hashedPassword = $userPasswordHasher->hashPassword(
                $user,
                $plainPassword
            );

            $user->setPassword($hashedPassword);

            // Give every new account the normal user role
            $user->setRoles(['ROLE_USER']);

            // New users are not blocked
            $user->setIsBlocked(false);

            // Get the uploaded profile picture
            /** @var UploadedFile|null $imageFile */
            $imageFile = $form->get('image')->getData();

            // Upload the profile picture if one was selected
            if ($imageFile) {
                $fileName = $fileUploader->upload(
                    $imageFile,
                    'users'
                );

                // Save the filename in the database
                $user->setImage($fileName);
            }

            // Save the user in the database
            $entityManager->persist($user);
            $entityManager->flush();

            // Send the user to the login page
            return $this->redirectToRoute('app_login');
        }

        return $this->render('registration/register.html.twig', [
            'registrationForm' => $form,
        ]);
    }
}