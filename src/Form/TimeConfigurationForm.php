<?php

namespace App\Form;

use App\Entity\TimeConfiguration;
use App\Enum\daysEnum;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\TimeType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class TimeConfigurationForm extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('day', ChoiceType::class, [
                'label' => 'Jour',
                'choices' => daysEnum::cases(),
                'choice_label' => fn ($choice) => $choice->value,
                'choice_value' => fn ($choice) => $choice?->name,
            ])
            ->add('openTime', TimeType::class, [
                'label' => 'Heure d\'ouverture',
                'widget' => 'single_text',
                'input' => 'datetime',
            ])
            ->add('closeTime', TimeType::class, [
                'label' => 'Heure de fermeture',
                'widget' => 'single_text',
                'input' => 'datetime',
            ])
            ->add('rdvInterval', TextType::class, [
                'label' => 'Durée des rendez-vous (ex: 00:30:00)',
                'required' => false,
                'mapped' => false, // on va convertir manuellement
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => TimeConfiguration::class,
        ]);
    }
}
