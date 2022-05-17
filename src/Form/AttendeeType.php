<?php

namespace App\Form;

use App\Entity\Attendee;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class AttendeeType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder->add('Identity', NumberType::class, ['attr' => ['class' => 'form-control mt-2 mb-2'], 'label_format' => 'Identiteitsnummer']);
        $builder->add('Comments', TextareaType::class, ['attr' => ['class' => 'form-control mt-2 mb-2'], 'label_format' => 'Opmerkingen (optioneel)', 'required' => false]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Attendee::class,
        ]);
    }
}
