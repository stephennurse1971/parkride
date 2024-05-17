<?php

namespace App\Form;

use App\Entity\ServicesOffered;
use App\Entity\WebsiteContacts;

use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;

use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class WebsiteContactsType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('firstName')
            ->add('lastName')
            ->add('email')
            ->add('mobile')
            ->add('notes')
            ->add('dateTime', DateTimeType::class, [
                'widget' => 'single_text',
                'required' => false,
            ])
            ->add('service', EntityType::class, [
                'class' => ServicesOffered::class,
                'choice_label' => 'serviceOffered',
                'required' => true,
                'empty_data' => null,
            ])
            ->add('status', ChoiceType::class, [
                'multiple' => false,
                'placeholder' => false,
                'expanded' => true,
                'required' => false,
                'choices' => [
                    'Pending' => 'Pending',
                    'Accepted' => 'Accepted',
                    'Junk' => 'Junk',
                ],
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => WebsiteContacts::class,
        ]);
    }
}
