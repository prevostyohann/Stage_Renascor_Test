<?php

namespace App\Form;

use App\Repository\TypeOfServiceRepository;
use Symfony\Component\Form\Extension\Core\Type\TimeType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use App\Entity\TypeOfService;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\AbstractType;
use Doctrine\ORM\EntityRepository;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;

class OfficeTypeOfServiceType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
{
    $em = $options['em'];

    $builder
        ->add('speciality', EntityType::class, [
            'class' => \App\Entity\Speciality::class,
            'choice_label' => 'name',
            'placeholder' => 'Choisir une spécialité',
            'mapped' => false, // utilisé uniquement pour filtrer côté JS
        ])
        ->add('typeOfService', EntityType::class, [
            'label' => 'Type of Service (en choisir un seul)',
            'class' => TypeOfService::class,
            'choice_label' => 'name',
            'multiple' => true,
            'expanded' => false,
            'choices' => $em->getRepository(TypeOfService::class)->findAll(), // Important !
        ])
        ->add('price')
        ->add('currency', ChoiceType::class, [
    'label' => 'Devise',
    'choices' => [
        'Euro (€)' => '€',
        'Dollar US ($)' => '$',
        'Livre Sterling (£)' => '£',
        'Franc Suisse (CHF)' => 'CHF',
        'Dollar Canadien (CAD)' => 'CAD',
        'Yen Japonais (¥)' => '¥',
        'Dollar Australien (AUD)' => 'AUD',
        'Couronne Suédoise (SEK)' => 'SEK',
        'Couronne Norvégienne (NOK)' => 'NOK',
        'Zloty Polonais (PLN)' => 'PLN',
        'Rouble Russe (₽)' => '₽',
        'Tenge Kazakh (₸)' => '₸',
    ],
    'placeholder' => 'Choisir une devise',
])
        ->add('duration', TextType::class, [
            'label' => 'Durée des rendez-vous (ex: 00:30:00)',
            'required' => false,
            'mapped' => false, // converti manuellement
        ]);
}

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => \App\Entity\OfficeTypeOfService::class,
            'em' => null, // pour passer EntityManagerInterface
        ]);
    }
}
