<?php

namespace App\Form;

use App\Entity\Booking;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class BookingType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('libelle', TextType::class, [
                'label' => 'Événement',
            ])
         
            ->add('montant', NumberType::class, [
                'label' => 'Montant',
            ])
            // Fields not belonging to the Booking entity, set mapped to false
            ->add('nom', TextType::class, [
                'label' => 'Nom',
                'mapped' => false,
            ])
            ->add('prenom', TextType::class, [
                'label' => 'Prénom',
                'mapped' => false,
            ])
            ->add('numeroCarte', TextType::class, [
                'label' => 'Numéro de carte',
                'mapped' => false,
            ])
            ->add('typeCarte', ChoiceType::class, [
                'label' => 'Type de carte',
                'choices' => [
                    'Visa' => 'visa',
                    'MasterCard' => 'mastercard',
                    'American Express' => 'amex',
                ],
                'mapped' => false,
            ])
            ->add('cryptogramme', TextType::class, [
                'label' => 'Cryptogramme',
                'mapped' => false,
            ])
            ->add('dateExpiration', DateTimeType::class, [
                'label' => 'Date d\'expiration',
                'widget' => 'single_text',
                'mapped' => false,
            ])
            ->add('submit', SubmitType::class, [
                'label' => 'Réserver',
            ]);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Booking::class,
        ]);
    }
}
