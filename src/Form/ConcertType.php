<?php

namespace App\Form;

use App\Entity\Band;
use App\Entity\Concert;
use App\Entity\Stage;
use DateTime;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Validator\Constraints\Range;

class ConcertType extends AbstractType
{

    private $festivalStartDate;
    private $festivalEndDate;

    public function __construct($festivalStartDate, $festivalEndDate)
    {
        $this->festivalStartDate = new \DateTime($festivalStartDate);
        $this->festivalEndDate = new \DateTime($festivalEndDate);
    }
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {

            $formatedStartDate= $this->festivalStartDate->format('d/m/Y');
            $formatedEndDate= $this->festivalEndDate->format('d/m/Y');

        $builder
            ->add('ConcertDate', DateTimeType::class, [
                'widget' => 'single_text',
                'minutes' => ['00'],
                
                           'constraints' => [
                    new Range([
                        'min' => $this->festivalStartDate,
                        'max' => $this->festivalEndDate,
                        'notInRangeMessage' => 'Les dates de concert doivent être entre le ' . $formatedStartDate . ' et le ' . $formatedEndDate,
                    ]),
                ],
              
            ])
            ->add('Artist', EntityType::class, [
                'class' => Band::class,
                'choice_label' => 'name',
            ])
            ->add('Stage', EntityType::class, [
                'class' => Stage::class,
                'choice_label' => 'name',
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Concert::class,
        ]);
    }
}
