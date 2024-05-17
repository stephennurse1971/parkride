<?php

namespace App\Form;

use App\Entity\FlightDestinations;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class FlightDestinationsType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('departureCity')
            ->add('departureCode')
            ->add('arrivalCity')
            ->add('arrivalCode')
            ->add('dateStart', DateType::class, [
                'label' => 'Start date',
                'widget' => 'single_text',
                'required' => false
            ])
            ->add('dateEnd', DateType::class, [
                'label' => 'End date',
                'widget' => 'single_text',
                'required' => false
            ])
            ->add('adminOnly')
            ->add('isActive')
            ->add('lastScraped', DateType::class, [
                'label' => 'Last Scraped',
                'widget' => 'single_text',
                'required' => false
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => FlightDestinations::class,
        ]);
    }
}
