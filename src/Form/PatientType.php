<?php

namespace App\Form;

use App\Entity\Patient;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class PatientType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('documentType')
            ->add('document')
            ->add('firstName')
            ->add('secondName')
            ->add('firstLastName')
            ->add('secondLastName')
            ->add('birthday')
            ->add('phone')
            ->add('secondPhone')
            ->add('department')
            ->add('municipality')
            ->add('address')
            ->add('email')
            ->add('gender')
            ->add('bloodGroup')
            ->add('rh')
            ->add('processType')
            ->add('entityHealth')
            ->add('regime')
            ->add('appointmentType')
            ->add('service')
            ->add('authorizationNumber')
            ->add('imagePath')
            ->add('pathImageEPS')
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Patient::class,
        ]);
    }
}
