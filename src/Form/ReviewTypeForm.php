<?php

namespace App\Form;

use App\Entity\Review;
use App\Enum\notesEnum;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ReviewTypeForm extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('note', ChoiceType::class, [
                'label' => 'Note',
                'choices' => [
                '⭐' => notesEnum::Note1,
                '⭐⭐' => notesEnum::Note2,
                '⭐⭐⭐' => notesEnum::Note3,
                '⭐⭐⭐⭐' => notesEnum::Note4,
                '⭐⭐⭐⭐⭐' => notesEnum::Note5,
                ],
                'expanded' => true, // affiché en boutons radio
                'multiple' => false,
            ])
            ->add('comment', TextareaType::class, [
                'label' => 'Commentaire',
                'required' => false,
                'attr' => ['placeholder' => 'Partagez votre expérience...'],
            ]);
        // On ne met pas les champs user et office ici car ils seront fixés dans le contrôleur
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Review::class,
        ]);
    }
}
