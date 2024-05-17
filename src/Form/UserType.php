<?php

namespace App\Form;

use App\Entity\Countries;
use App\Entity\User;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Security\Core\Security;

class UserType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('email')
            ->add('password')
            ->add('firstName')
            ->add('lastName')
            ->add('mobile')
            ->add('mobile2')
            ->add('landline')
            ->add('gender', ChoiceType::class, [
                'multiple' => false,
                'placeholder' => false,
                'expanded' => true,
                'required' => false,
                'choices' => [
                    'Male' => 'Male',
                    'Female' => 'Female',
                ],
            ])
            ->add('linkedIn', TextType::class, [
                'label' => 'LinkedIn',
                'required'=>false
            ])
            ->add('dateOfBirth', DateType::class, [
                'widget' => 'single_text',
                'required'=>false
            ])
            ->add('addressStreet')
            ->add('addressCity')
            ->add('addressPostCode')
            ->add('addressCountry', EntityType::class, [
                'class' => Countries::class,
                'choice_label' => 'country',
                'required' => false,
                'empty_data' => null,
            ])
            ->add('notes')
            ->add('officialFormDisplayLanguage', ChoiceType::class, [
                'multiple' => false,
                'label' => 'View forms with the following languages',
                'placeholder' => false,
                'expanded' => true,
                'required' => false,
                'choices' => [
                    'English' => 'English',
                    'Greek' => 'Greek',
                    'Greek & English' => 'Greek & English',
                ],
            ])
        ;


        if (in_array('ROLE_ADMIN', $this->security->getUser()->getRoles())  || in_array('ROLE_SUPER_ADMIN', $this->security->getUser()->getRoles()) ) {
            $builder->add('roles', ChoiceType::class, [
                'choices' => [
                    'ROLE_SUPER_ADMIN' => 'ROLE_SUPER_ADMIN',
                    'ROLE_ADMIN' => 'ROLE_ADMIN',
                    'ROLE_STAFF' => 'ROLE_STAFF',
                    'ROLE_CLIENT' => 'ROLE_CLIENT',
                ],
               'mapped' => false,
               // 'data' => ['ROLE_CLIENT'],
                'multiple' => TRUE
            ]);
        }
        $user = $options['user'];
        if($user) {
            if (in_array('ROLE_STAFF', $user->getRoles()) || in_array('ROLE_ADMIN', $user->getRoles()) || in_array('ROLE_SUPER_ADMIN', $user->getRoles())) {
                $builder->add('employeeRank')
                    ->add('photo', FileType::class, [
                        'label' => 'Employee Photo',
                        'mapped' => false,
                        'required' => false,
                        'attr' => [
                            'class' => 'photo'
                        ]
                    ]);
            }
        }

    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => User::class,
            'user'=>null
        ]);
    }

    public function __construct(Security $security)
    {
        $this->security = $security;
    }
}
