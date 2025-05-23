<?php

namespace App\Form;

use Symfony\Component\Form\Extension\Core\Type\TextType;
use App\Entity\Office;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use App\Entity\Profession;

class OfficeForm extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('businessName')
            ->add('siret')
            ->add('businessProof')
            ->add('personalSiteLink')
            ->add('profilePhotoLink')
            ->add('officePhone')
         
            ->add('officeAddress', TextType::class, [
                'attr' => [
                    'data-autocomplete' => 'address',
                    'placeholder' => '10 rue de Paris',
                ],
            ])
            
            
            
            
            
            ->add('description', TextareaType::class)
            ->add('professions', EntityType::class, [
            'class' => Profession::class,
            'choice_label' => 'name',
            'label' => 'Profession',
            'placeholder' => 'Choisissez une profession',
            'expanded' => false,
            'multiple' => true,
            'attr' => [
                'class' => 'block w-full px-4 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-teal-500 focus:border-teal-500',
            ],
        ])


            ->add('officePostalCode', HiddenType::class)
            ->add('officeCity', HiddenType::class)
            ->add('officeLatitude', HiddenType::class)
            ->add('officeLongitude', HiddenType::class)
            ->add('officeStreetNumber', HiddenType::class)
            ->add('officeStreetName', HiddenType::class);
            // Pas besoin d'ajouter `user`, il peut être injecté dans le contrôleur
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Office::class,
        ]);
    }
}