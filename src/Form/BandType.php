<?php

namespace App\Form;

use App\Entity\Band;
use App\Entity\MusicStyle;
use PHPUnit\TextUI\XmlConfiguration\CodeCoverage\Report\Text;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Validator\Constraints\NotBlank;

class BandType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('band_name', TextType::class,
                [
                    'required' => true,
                    'constraints' => [
                        new NotBlank([
                            'message' => 'Veuillez saisir le nom du groupe ou de l\'artiste.',
                        ]),
                    ],
                ]   
            )
            ->add('band_description', TextareaType::class, [
                'required' => true,
                'constraints' => [
                    new NotBlank([
                        'message' => 'Veuillez une description du groupe ou de l\'artiste.',
                    ]),
                    
                ],

            ])
            ->add('band_image', HiddenType::class, 
            )
            ->add('file', FileType::class, [
                'label' => 'Image',
                'mapped' => false,
                'required' => true,
            ])
            ->add('music_style', EntityType::class, [
                'class' => MusicStyle::class,
                'choice_label' => 'music_style_name',
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Band::class,
        ]);
    }
}
