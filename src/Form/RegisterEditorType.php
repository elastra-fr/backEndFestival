<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\FormType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class RegisterEditorType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('email', null, [
                'label' => 'Email ',
                'attr' => [
                    'placeholder' => 'Email',
                ],
            ])
            ->add('firstName', null, [
                'label' => 'Prénom ',
                'attr' => [
                    'placeholder' => 'Prénom',
                ],
            ])
            ->add('lastName', null, [
                'label' => 'Nom ',
                'attr' => [
                    'placeholder' => 'Nom',
                ],
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
