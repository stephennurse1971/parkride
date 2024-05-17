<?php

namespace App\Form;

use App\Entity\DocumentGuidelines;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class DocumentGuidelinesType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('document', ChoiceType::class, [
                'multiple' => false,
                'placeholder' => false,
                'expanded' => true,
                'required' => false,
                'choices' => [
                    'Passport' => 'Passport',
                    'Birth Marriage Death certificate' => 'Birth Marriage Death certificate',
                    'Financial Statement' => 'Financial Statement',
                    'Tenancy Agreement' => 'Tenancy Agreement',
                    'Utility Bill' => 'Utility Bill',
                    'Employment Contract' => 'Employment Contract',
                    'Criminal Record Check' => 'Criminal Record Check',
                    'Medical' => 'Medical',
                    'Health Insurance' => 'Health Insurance',
                    'School Attendance Certificate' => 'School Attendance Certificate',
                    'Driving License' => 'Driving License',
                ],
            ])
            ->add('guidelines')
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => DocumentGuidelines::class,
        ]);
    }
}
