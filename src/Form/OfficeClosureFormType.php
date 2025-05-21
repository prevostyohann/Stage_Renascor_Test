<?php

namespace App\Form;

use App\Entity\OfficeClosure;
use App\Entity\Office;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class OfficeClosureFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('start', DateTimeType::class, [
                'label' => 'Début',
                'widget' => 'single_text',
            ])
            ->add('end', DateTimeType::class, [
                'label' => 'Fin',
                'widget' => 'single_text',
            ]);
            
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => OfficeClosure::class,
        ]);
    }
}
