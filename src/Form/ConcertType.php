<?php

namespace App\Form;

use App\Entity\Band;
use App\Entity\Concert;
use App\Entity\Stage;
use DateTime;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Validator\Constraints\Range;
use Doctrine\ORM\EntityRepository;

class ConcertType extends AbstractType
{

    private $festivalStartDate;
    private $festivalEndDate;
    private $initialFestivalEndDate;

    public function __construct($festivalStartDate, $festivalEndDate)
    {
        $this->festivalStartDate = new \DateTime($festivalStartDate);
        $this->initialFestivalEndDate = new \DateTime($festivalEndDate);
        $this->festivalEndDate = (new \DateTime($festivalEndDate))->modify('+1 day');
    }
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {

            $formatedStartDate= $this->festivalStartDate->format('d/m/Y');
            $formatedEndDate= $this->initialFestivalEndDate->format('d/m/Y');


        $builder
    ->add('ConcertDate', DateTimeType::class, [
        'widget' => 'single_text',
        'html5' => true,
        'attr' => [
            'value' => $this->festivalStartDate->format('Y-m-d\TH:00'), 
            'min' => $this->festivalStartDate->format('Y-m-d\TH:00'),
            'max' => $this->festivalEndDate->format('Y-m-d\TH:00'),
        ],
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
                'query_builder' => function (EntityRepository $er) {
                    return $er->createQueryBuilder('b')
                        ->orderBy('b.name', 'ASC');
                },
            ])
            ->add('Stage', EntityType::class, [
                'class' => Stage::class,
                'choice_label' => 'name',
                'query_builder' => function (EntityRepository $er) {
                    return $er->createQueryBuilder('s')
                        ->orderBy('s.name', 'ASC');
                },
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
