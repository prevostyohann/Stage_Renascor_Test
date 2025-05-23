<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;

class UserProfileType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('email')
            ->add('username', TextType::class, [
                'disabled' => false, // On laisse le champ en lecture seule
                'label' => 'Nom d\'utilisateur :',
            ])
            ->add('lastName', TextType::class, [
                'label' => 'Nom :',
            ])
            ->add('firstName', TextType::class, [
                'label' => 'Prénom :',
            ])
            ->add('addressComplement', TextType::class, [
                'required' => false,
                'label' => 'Complément d\'adresse :',
                'attr' => [
                    'placeholder' => 'Bâtiment, étage, résidence, etc.',
                ],
            ])
            ->add('address', TextType::class, [
                'attr' => [
                    'data-autocomplete' => 'address',
                    'placeholder' => '10 rue de Paris',
                    'label' => 'Addresse :',
                ],
            ])
            ->add('birthDate', null, [
                'widget' => 'single_text',
                'label' => 'Date de Naissance :',
            ])
            ->add('phoneNumber', TextType::class, [
                'label' => 'Téléphone :',
            ])

            
            // Si tu souhaites permettre à l'utilisateur de changer son mot de passe
            // tu peux ajouter cette partie de manière conditionnelle
            ->add('plainPassword', RepeatedType::class, [
                'type' => PasswordType::class,
                'mapped' => false,
                'required' => false, // Le champ n'est pas requis pour la mise à jour
                'first_options' => [
                    'label' => 'Mot de passe :',
                    'attr' => ['autocomplete' => 'new-password'],
                ],
                'second_options' => [
                    'label' => 'Confirmation du mot de passe :',
                    'attr' => ['autocomplete' => 'new-password'],
                ],
                'invalid_message' => 'Les mots de passe doivent correspondre.',
            ])
            ->add('postalCode', HiddenType::class)
            ->add('city', HiddenType::class)
            ->add('latitude', HiddenType::class)
            ->add('longitude', HiddenType::class)
            ->add('streetNumber', HiddenType::class, [
            'required' => false,
            'empty_data' => '', // 👈 Ajoute cette ligne
        ])
            ->add('streetName', HiddenType::class);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
