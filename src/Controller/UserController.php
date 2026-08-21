<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\ProfileType;
use App\Service\FileUploader;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Attribute\Route;

class UserController extends AbstractController
{
    #[Route('/profile', name: 'app_profile')]
    public function profile(
        Request $request,
        EntityManagerInterface $entityManager,
        UserPasswordHasherInterface $userPasswordHasher,
        FileUploader $fileUploader
    ): Response {
        $this->denyAccessUnlessGranted('ROLE_USER');

        /** @var User $user */
        $user = $this->getUser();

        $form = $this->createForm(
            ProfileType::class,
            $user
        );

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            // Get the new password
            $plainPassword = $form
                ->get('plainPassword')
                ->getData();

            // Only change the password if the user entered a new one
            if ($plainPassword) {
                $hashedPassword = $userPasswordHasher->hashPassword(
                    $user,
                    $plainPassword
                );

                $user->setPassword($hashedPassword);
            }

            // Check if the user wants to remove the current profile picture
            $removeImage = $form
                ->get('removeImage')
                ->getData();

            if ($removeImage) {

                // Remove the profile picture from the database
                $user->setImage(null);

            } else {

                // Get the new profile picture
                /** @var UploadedFile|null $imageFile */
                $imageFile = $form
                    ->get('image')
                    ->getData();

                // Upload the picture if the user selected one
                if ($imageFile) {

                    $fileName = $fileUploader->upload(
                        $imageFile,
                        'users'
                    );

                    // Save the filename in the database
                    $user->setImage($fileName);
                }
            }

            // Save all profile changes
            $entityManager->flush();

            // Show success message
            $this->addFlash(
                'success',
                'Your profile has been updated successfully.'
            );

            return $this->redirectToRoute('app_profile');
        }

        return $this->render('user/profile.html.twig', [
            'form' => $form,
            'user' => $user,
        ]);
    }
}
