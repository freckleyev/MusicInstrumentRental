<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Form\FormBuilderInterface;

class ProfileType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('firstName', TextType::class, [
                'label' => 'First Name',
                'constraints' => [
                    new Assert\NotBlank(
                        message: 'Please enter your first name.'
                    ),
                    new Assert\Length(
                        min: 3,
                        max: 255,
                        minMessage: 'First name must be at least {{ limit }} characters long.',
                        maxMessage: 'First name cannot exceed {{ limit }} characters.'
                    ),
                    new Assert\Regex(
                        pattern: "/^[\p{L}\s'-]+$/u",
                        message: 'First name can only contain letters, spaces, hyphens, and apostrophes.'
                    ),
                ],
            ])

            ->add('lastName', TextType::class, [
                'label' => 'Last Name',
                'constraints' => [
                    new Assert\NotBlank(
                        message: 'Please enter your last name.'
                    ),
                    new Assert\Length(
                        min: 3,
                        max: 255,
                        minMessage: 'Last name must be at least {{ limit }} characters long.',
                        maxMessage: 'Last name cannot exceed {{ limit }} characters.'
                    ),
                    new Assert\Regex(
                        pattern: "/^[\p{L}\s'-]+$/u",
                        message: 'Last name can only contain letters, spaces, hyphens, and apostrophes.'
                    ),
                ],
            ])

            ->add('email', EmailType::class, [
                'label' => 'Email',
                'constraints' => [
                    new Assert\NotBlank(
                        message: 'Please enter an email address.'
                    ),
                    new Assert\Email(
                        message: 'The email {{ value }} is not a valid email address.'
                    ),
                    new Assert\Length(
                        max: 180,
                        maxMessage: 'Email cannot be longer than {{ limit }} characters.'
                    ),
                ],
            ])

            ->add('plainPassword', PasswordType::class, [
                'label' => 'New Password',
                'mapped' => false,
                'required' => false,
                'attr' => [
                    'autocomplete' => 'new-password',
                ],
                'constraints' => [
                    new Assert\Length(
                        min: 6,
                        max: 4096,
                        minMessage: 'Your password must be at least {{ limit }} characters long.'
                    ),
                    new Assert\Regex(
                        pattern: '/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d).+$/',
                        message: 'Your password must contain at least one uppercase letter, one lowercase letter, and one number.'
                    ),
                ],
            ])

            ->add('image', FileType::class, [
                'label' => 'New Profile Picture',
                'mapped' => false,
                'required' => false,
                'attr' => [
                    'class' => 'form-control',
                ],
                'constraints' => [
                    new Assert\File(
                        maxSize: '2048k',
                        extensions: ['png', 'jpg', 'jpeg', 'webp'],
                        extensionsMessage: 'Please upload a valid image (PNG, WEBP, JPG or JPEG) max 2 MB.',
                    ),
                ],
            ])

            ->add('removeImage', CheckboxType::class, [
                'label' => 'Remove current profile picture ',
                'mapped' => false,
                'required' => false,
                'row_attr' => [
                    'class' => 'd-flex align-items-center gap-2 mb-3', // Controls spacing between input and label
                ],
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}