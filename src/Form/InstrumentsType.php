<?php

namespace App\Form;

use App\Entity\Categories;
use App\Entity\Instruments;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\MoneyType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints as Assert;

class InstrumentsType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name', TextType::class, [
                'label' => "Name*",
                'attr' => ['class' => 'form-control mb-3'],
            ])
            ->add('category', EntityType::class, [
                'label' => "Category*",
                'class' => Categories::class,
                'choice_label' => 'name',
                'placeholder' => 'Choose a category',
                'attr' => ['class' => 'form-select mb-3'],
            ])
            ->add('instrument_condition', TextType::class, [
                'label' => "Condition*",
                'attr' => ['class' => 'form-control mb-3'],
            ])
            ->add('description', TextareaType::class, [
                'label' => "Description*",
                'attr' => ['class' => 'form-control mb-3'],
            ])
            ->add('daily_rental_price', MoneyType::class, [
                'label' => "Daily Rental Price*",
                'currency' => 'EUR',
                'attr' => ['class' => 'form-control mb-3'],
            ])
            ->add('image', FileType::class, [
                'label' => 'Upload image',
                'mapped' => false,
                'required' => false,
                'attr' => ['class' => 'form-control mb-3'],
                'constraints' => [
                    new Assert\File(
                        maxSize: '2048k',
                        extensions: ['png', 'jpg', 'jpeg', 'webp'],
                        extensionsMessage: 'Please upload a valid image (PNG, WEBP, JPG or JPEG) max 2 MB.',
                    ),
                ],
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Instruments::class,
        ]);
    }
}
