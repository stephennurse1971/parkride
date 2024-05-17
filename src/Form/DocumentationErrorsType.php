<?php

namespace App\Form;

use App\Entity\DocumentationErrors;
use App\Entity\ServicesOffered;
use App\Entity\User;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class DocumentationErrorsType extends AbstractType
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
                    'Birth Marriage Death Certificate' => 'Birth Marriage Death Certificate',
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
            ->add('summaryCheckBox')
            ->add('description')
            ->add('remedy')
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => DocumentationErrors::class,
        ]);
    }
}
