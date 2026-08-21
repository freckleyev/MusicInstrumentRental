<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\IsTrue;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints as Assert;

class RegistrationFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('firstName', TextType::class, [
                'label' => 'First name',
                'constraints' => [
                    new NotBlank(
                        message: 'Please enter your first name.',
                    ),
                ],
            ])

            ->add('lastName', TextType::class, [
                'label' => 'Last name',
                'constraints' => [
                    new NotBlank(
                        message: 'Please enter your last name.',
                    ),
                ],
            ])

            ->add('email', null, [
                'label' => 'Email',
                'constraints' => [
                    new NotBlank(
                        message: 'Please enter your email.',
                    ),
                    new Assert\Email(
                        message: 'Please enter a valid email address.',
                    ),
                ],
            ])

            ->add('plainPassword', PasswordType::class, [
                'label' => 'Password',

                'mapped' => false,

                'attr' => [
                    'autocomplete' => 'new-password',
                ],

                'constraints' => [
                    new NotBlank(
                        message: 'Please enter a password.',
                    ),

                    new Length(
                        min: 6,
                        minMessage: 'Your password should be at least {{ limit }} characters.',
                        max: 4096,
                    ),
                ],
            ])

            ->add('image', FileType::class, [
                'label' => 'Profile image',

                'mapped' => false,

                'required' => false,

                'attr' => [
                    'class' => 'form-control',
                ],

                'constraints' => [
                    new Assert\File(
                        maxSize: '2048k',
                        extensions: ['png', 'jpg', 'jpeg', 'webp'],
                        extensionsMessage: 'Please upload a valid image (PNG, WEBP, JPG or JPEG), maximum 2 MB.',
                    ),
                ],
            ])

            ->add('agreeTerms', CheckboxType::class, [
                'label' => 'I agree to the terms and conditions.',

                'mapped' => false,

                'constraints' => [
                    new IsTrue(
                        message: 'You must agree to the terms and conditions.',
                    ),
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