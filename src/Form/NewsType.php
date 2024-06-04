<?php

namespace App\Form;

use App\Entity\News;
use Doctrine\ORM\Mapping\Entity;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use App\Entity\NewsCategory;

class NewsType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('NewsCategory', EntityType::class, [
                'class' => NewsCategory::class,
                'choice_label' => 'Category',
            ])
            ->add('title')
            ->add('news_content', TextareaType::class)
            ->add('enable_notification', CheckboxType::class, [
                'required' => false,
                'label' => 'Notification utilisateur', 
                'mapped' => false,
                'attr' => [
                    'class' => 'toggle-switch',
                ]
                
            ] 
            )
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => News::class,
        ]);
    }
}
