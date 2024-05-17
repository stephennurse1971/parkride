<?php

namespace App\Form;

use App\Entity\ImmigrationAppointments;
use App\Entity\User;
use App\Repository\UserRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ImmigrationAppointmentsType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('date', DateType::class, [
                'widget' => 'single_text',
                'required' => false,
            ])
            ->add('time')

            ->add('chaperone', EntityType::class, [
                'class' => User::class,
                'choice_label' => 'fullName',
                'choices'=>$this->userRepository->findByRole('ROLE_STAFF'),
                'required' => true,
                'empty_data' => null,
            ])
            ->add('client', EntityType::class, [
                'class' => User::class,
                'choice_label' => 'fullName',
                'required' => true,
                'empty_data' => null,
            ])
            ->add('calendarInvite')
            ->add('calendarReceipt')
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => ImmigrationAppointments::class,

        ]);
    }
    public function __construct(UserRepository $userRepository){
        $this->userRepository = $userRepository;
    }
}
