<?php

namespace App\Form;

use App\Entity\FaqCategory;
use App\Entity\FaqContent;
use PHPUnit\TextUI\XmlConfiguration\CodeCoverage\Report\Text;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class FaqContentType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('faqContentTitle')
            ->add('faqContentDetails', TextareaType::class)
            ->add('section', EntityType::class, [
                'class' => FaqCategory::class,
                'choice_label' => 'faqCategory',
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => FaqContent::class,
        ]);
    }
}
