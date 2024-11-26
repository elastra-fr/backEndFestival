<?php

namespace App\Form;

use App\Entity\MapPoint;
use App\Entity\MapPointsCategory;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class MapPointEntityType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('mapPointTitle')
            ->add('mapPointDescription')
            ->add('Longitude')
            ->add('Latitude')
            ->add('mapPointCategory', EntityType::class, [
                'class' => MapPointsCategory::class,
                'choice_label' => 'mapPointCategory',
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => MapPoint::class,
        ]);
    }
}
