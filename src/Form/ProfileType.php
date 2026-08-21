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
            ])

            ->add('lastName', TextType::class, [
                'label' => 'Last Name',
            ])

            ->add('email', EmailType::class, [
                'label' => 'Email',
            ])

            ->add('plainPassword', PasswordType::class, [
                'label' => 'New Password',
                'mapped' => false,
                'required' => false,
                'attr' => [
                    'autocomplete' => 'new-password',
                ],
                'constraints' => [
                    new Length(
                        min: 6,
                        minMessage: 'Your password should be at least {{ limit }} characters.',
                        max: 4096,
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
                'label' => 'Remove current profile picture',
                'mapped' => false,
                'required' => false,
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}