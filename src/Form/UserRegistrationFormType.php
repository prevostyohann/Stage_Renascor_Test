<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;

class UserRegistrationFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('email')
            ->add('username')
            ->add('lastName')
            ->add('firstName')
            ->add('addressComplement', TextType::class, [
                'required' => false,
                'label' => 'Complément d\'adresse',
                'attr' => [
                    'placeholder' => 'Bâtiment, étage, résidence, etc.',
                ],
            ])
            ->add('address', TextType::class, [
                'attr' => [
                    'data-autocomplete' => 'address',
                    'placeholder' => '10 rue de Paris',
                ],
            ])
            ->add('birthDate', null, [
                'widget' => 'single_text',
            ])
            ->add('phoneNumber')
            ->add('plainPassword', RepeatedType::class, [
                'type' => PasswordType::class,
                'mapped' => false, // très important pour ne pas lier à l'entité
                'first_options' => [
                    'label' => 'Mot de passe',
                    'attr' => ['autocomplete' => 'new-password'],
                ],
                'second_options' => [
                    'label' => 'Confirmation du mot de passe',
                    'attr' => ['autocomplete' => 'new-password'],
                ],
                'invalid_message' => 'Les mots de passe doivent correspondre.',
            ])
            ->add('postalCode', HiddenType::class)
            ->add('city', HiddenType::class)
            ->add('latitude', HiddenType::class)
            ->add('longitude', HiddenType::class)
            ->add('streetNumber', HiddenType::class)
            ->add('streetName', HiddenType::class);

    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
