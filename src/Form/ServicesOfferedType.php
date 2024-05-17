<?php

namespace App\Form;

use App\Entity\ServicesOffered;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\RadioType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ServicesOfferedType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('ranking')
            ->add('serviceOffered')
            ->add('includeInFooter')
            ->add('requiresImmigrationAppointment')
            ->add('serviceArea', ChoiceType::class,[
                'label' => 'Service Area',
                'choices'=>[
                    'Immigration' => 'Immigration',
                    'Vehicles' => 'Vehicles',
                    'IDs' => 'IDs',
                    'Tax' => 'Tax',
                    'Other' => 'Other'
                ]
            ])
            ->add('docsPassport', ChoiceType::class,[
                'label' => 'Passport',
                'choices'=>[
                    'Yes' => 1,
                    'No' => 0
                    ]
            ])
            ->add('docsTenancyAgreement', ChoiceType::class,[
                'label' => 'Tenancy Agreement',
                'choices'=>[
                    'Yes' => 1,
                    'No' => 0
                ]
            ])
            ->add('docsUtilityBill', ChoiceType::class,[
                'label' => 'Utility Bill',
                'choices'=>[
                    'Yes' => 1,
                    'No' => 0
                ]
            ])
            ->add('docsBirthMarriageDeathCertificate', ChoiceType::class,[
                'label' => 'Birth Marriage Death Certificate',
                'choices'=>[
                    'Yes' => 1,
                    'No' => 0
                ]
            ])
            ->add('docsEmploymentContract', ChoiceType::class,[
                'label' => 'Employment Contract',
                'choices'=>[
                    'Yes' => 1,
                    'No' => 0
                ]
            ])
            ->add('docsFinancialStatements', ChoiceType::class,[
                'label' => 'Financial Statements',
                'choices'=>[
                    'Yes' => 1,
                    'No' => 0
                ]
            ])
            ->add('docsP60', ChoiceType::class,[
                'label' => 'P60',
                'choices'=>[
                    'Yes' => 1,
                    'No' => 0
                ]
            ])
            ->add('docsSchoolAttendanceCertificate', ChoiceType::class,[
                'label' => 'School Attendance Certificate',
                'choices'=>[
                    'Yes' => 1,
                    'No' => 0
                ]
            ])
            ->add('docsCriminalRecordCheck', ChoiceType::class,[
                'label' => 'Criminal Record Check',
                'choices'=>[
                    'Yes' => 1,
                    'No' => 0
                ]
            ])
            ->add('docsHealthInsurance', ChoiceType::class,[
                'label' => 'Health Insurance',
                'choices'=>[
                    'Yes' => 1,
                    'No' => 0
                ]
            ])
            ->add('docsMedical', ChoiceType::class,[
                'label' => 'Medical',
                'choices'=>[
                    'Yes' => 1,
                    'No' => 0
                ]
            ])
            ->add('docsDrivingLicense', ChoiceType::class,[
                'label' => 'Driving License',
                'choices'=>[
                    'Yes' => 1,
                    'No' => 0
                ]
            ])
            ->add('price')
            ->add('priceUpfront')
            ->add('comments')
            ->add('officialForm', ChoiceType::class,[
                'label' => 'Official Form Required',
                'choices'=>[
                    'TBA' => 'TBA',
                    'MEU1' => 'MEU1',
                    'MEU3' => 'MEU3',
                    'Bank Of Cyprus Application' => 'Bank of Cyprus Application'
                ]
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => ServicesOffered::class,
        ]);
    }
}
