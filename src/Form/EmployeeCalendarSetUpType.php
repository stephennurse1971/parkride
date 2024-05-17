<?php

namespace App\Form;

use App\Entity\EmployeeCalendarSetUp;
use App\Entity\User;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class EmployeeCalendarSetUpType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('employee', EntityType::class, [
                'class' => User::class,
                'choice_label' => 'fullName',
                'choices'=>$options['employee'],
                'required' => true,
                'empty_data' => null,
            ])

            ->add('dayOfWeek', ChoiceType::class, [
                'multiple' => true,
                'expanded' => false,
                'choices' => [
                    'Mon' => 'Mon',
                    'Tue' => 'Tue',
                    'Wed' => 'Wed',
                    'Thu' => 'Thu',
                    'Fri' => 'Fri',
                ]
            ])
            ->add('startDate', DateType::class, [
                'widget' => 'single_text',
            ])
            ->add('endDate', DateType::class, [
                'widget' => 'single_text',
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => EmployeeCalendarSetUp::class,
            'employee'=>null
        ]);
    }
}
