<?php

namespace App\Form;

use App\Entity\Emails;
use App\Entity\ServicesOffered;
use App\Entity\User;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class EmailsType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('client', EntityType::class, [
                'class' => User::class,
                'choice_label' => 'fullName',
                'required' => true,
                'empty_data' => null,
            ])
            ->add('service', EntityType::class, [
                'class' => ServicesOffered::class,
                'choice_label' => 'serviceOffered',
                'required' => true,
                'empty_data' => null,
            ])
            ->add('stage')
            ->add('recipientName')
            ->add('recipientEmail')
            ->add('dateTime', DateType::class, [
                'widget' => 'single_text',
            ])
            ->add('sender')
            ->add('subject')
            ->add('body')
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Emails::class,
        ]);
    }
}
