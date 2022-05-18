<?php

namespace App\Form;

use App\Entity\Trip;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class TripType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
         $builder->add('title', TextType::class, ['attr' => ['class' => 'form-control mt-2 mb-2'], 'label_format' => 'Titel']);
         $builder->add('destination', TextType::class, ['attr' => ['class' => 'form-control mt-2 mb-2'], 'label_format' => 'Bestemming']);
         $builder->add('description', TextareaType::class, ['attr' => ['class' => 'form-control mt-2 mb-2'], 'label_format' => 'Omschrijving']);
         $builder->add('startdate', DateType::class, ['attr' => ['class' => 'form-control mt-2 mb-2'], 'label_format' => 'Begindatum']);
         $builder->add('enddate', DateType::class, ['attr' => ['class' => 'form-control mt-2 mb-2'], 'label_format' => 'Einddatum']);
         $builder->add('maxStudents', NumberType::class, ['attr' => ['class' => 'form-control mt-2 mb-2'], 'label_format' => 'Maximum aantal studenten']);
         ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Trip::class,
        ]);
    }
}
