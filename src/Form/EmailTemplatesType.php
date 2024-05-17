<?php

namespace App\Form;

use App\Entity\EmailTemplates;
use App\Entity\ServicesOffered;
use App\Entity\User;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class EmailTemplatesType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('service', EntityType::class, [
                'class' => ServicesOffered::class,
                'choice_label' => 'serviceOffered',
                'required' => true,
                'empty_data' => null,
            ])
            ->add('name')
            ->add('stage', ChoiceType::class, [
                'multiple' => false,
                'expanded' => false,
                'choices' => [
                    '1. Introductionary' => '1. Introductionary',
                    '2. Information-gathering' => '2. Information-gathering',
                    '3. Review' => '3. Review',
                    '4. Appointments' => '4. Appointments',
                    '5. Application' => '5. Application',
                    '6. Success' => '6. Success',
                    '7. Future-Business'=>'7. Future-Business'
                ],])
            ->add('subject')
            ->add('body', TextareaType::class,[
                'required'=>false
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => EmailTemplates::class,
        ]);
    }
}
